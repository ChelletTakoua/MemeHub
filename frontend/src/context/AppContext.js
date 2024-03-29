import { createContext, useState, useEffect, useCallback } from "react";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import axios from "axios";

const AppContext = createContext();

const AppProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [error, setError] = useState(null);
  const [isLoading, setIsLoading] = useState(true);

  const checkAuth = useCallback(async () => {
    try {
      setIsLoading(true);
      const res = await axios.get("/api/check-auth.php", {
        withCredentials: true,
      });
      setUser(res.data.user);
    } catch (error) {
      setUser(null);
    } finally {
      setIsLoading(false);
    }
  }, [setUser, setIsLoading]);

  useEffect(() => {
    setUser({
      id: 1,
      username: "test",
      email: "example@test.com",
    });
    checkAuth();
  }, [setUser, checkAuth]);

  const register = async (username, password) => {
    try {
      setIsLoading(true);
      const res = await axios.post(
        "/api/register.php",
        {
          username,
          password,
        },
        { withCredentials: true }
      );
      setUser(res.data.user);
      setError(null);
    } catch (error) {
      setUser(null);
      setError(error.response.data);
    } finally {
      setIsLoading(false);
    }
  };

  const login = async (username, password) => {
    try {
      setIsLoading(true);
      const res = await axios.post(
        "/api/login.php",
        {
          username,
          password,
        },
        { withCredentials: true }
      );
      setUser(res.data.user);
      setError(null);
    } catch (error) {
      setUser(null);
      setError(error.response.data);
    } finally {
      setIsLoading(false);
    }
  };

  const logout = async () => {
    try {
      setIsLoading(true);
      setUser(null);
      await axios.get("/api/logout.php", { withCredentials: true });
    } catch (error) {
      setUser(null);
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <AppContext.Provider
      value={{ user, setUser, toast, register, login, logout }}
    >
      {children}
      <ToastContainer
        position="bottom-right"
        autoClose={4000}
        pauseOnHover={true}
        draggable={false}
        theme="dark"
      />
    </AppContext.Provider>
  );
};

export { AppContext, AppProvider };
