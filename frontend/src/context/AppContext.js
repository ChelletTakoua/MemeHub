import { createContext, useState, useCallback } from "react";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { api, userApi } from "../services/api";
import { useNavigate } from "react-router-dom";

const AppContext = createContext();

const AppProvider = ({ children }) => {
  const [user, setUser] = useState(null);

  const navigate = useNavigate();

  const checkAuth = useCallback(async () => {
    try {
      const res = await userApi.getUserAuth();
      setUser(res.data.data.user);
    } catch (error) {
      setUser(null);
    }
  }, [setUser]);

  const register = async (username, email, password) => {
    try {
      await api.register({ username, email, password });
      setUser(null);
      toast.success(
        `${username} registered successfully! Please verify your email and login.`
      );
      await userApi.sendVerifEmail(username);
      navigate("/login");
      window.scrollTo(0, 0);
    } catch (error) {
      setUser(null);
      toast.error(error.response?.data.message);
    }
  };

  const login = async (username, password) => {
    try {
      const res = await api.login({ username, password });
      setUser(res?.data.data.user);
      toast.success(`Welcome back, ${username}`);
      navigate("/");
    } catch (error) {
      setUser(null);
      if (error?.response?.status === 403) {
        try {
          await userApi.sendVerifEmail(username);
          toast.success(
            "Please verify your email to login. Check your inbox and spam folder."
          );
        } catch (error) {
          toast.error(error?.response?.data.message);
        }
      } else {
        toast.error(error?.response?.data.message);
      }
    }
  };

  const logout = async () => {
    try {
      await api.logout();
      setUser(null);
      toast.success("Come back soon!");
      navigate("/");
    } catch (error) {
      setUser(null);
    }
  };

  return (
    <AppContext.Provider
      value={{
        user,
        setUser,
        register,
        login,
        logout,
        checkAuth,
        toast,
      }}
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
