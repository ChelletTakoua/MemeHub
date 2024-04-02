import React, { useContext, useEffect, useState } from "react";
import { Route, Routes, useLocation } from "react-router-dom";
import Home from "./pages/Home";
import Login from "./pages/Login";
import Register from "./pages/Register";
import AdminDashboard from "./pages/AdminDashboard";
import MemeEdit from "./pages/MemeEdit";
import Profile from "./pages/Profile";
import About from "./pages/AboutUs";
import VerifyEmail from "./pages/VerifyEmail";
import NotFound from "./pages/NotFound";
import Navbar from "./components/Navbar";
import Footer from "./components/Footer";
import Loading from "./components/Loading";
import { AppContext } from "./context/AppContext";
import "./App.css";

function App() {
  const [isLoading, setIsLoading] = useState(false);
  const { user, checkAuth } = useContext(AppContext);

  useEffect(() => {
    const init = async () => {
      try {
        setIsLoading(true);
        await checkAuth();
      } catch (error) {
        console.error("Error checking auth:", error);
      } finally {
        setTimeout(() => {
          setIsLoading(false);
        }, 1000);
      }
    };
    init();
  }, [checkAuth]);

  const location = useLocation();
  const hideNavbar =
    location.pathname === "/verifyEmail" ||
    location.pathname === "/resetPassword";

  return isLoading ? (
    <Loading />
  ) : (
    <div className="app">
      {!hideNavbar && <Navbar />}
      <main className="app-main">
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/about" element={<About />} />
          <Route path="/verifyEmail" element={<VerifyEmail />} />
          {!user && (
            <>
              <Route path="/login" element={<Login />} />
              <Route path="/register" element={<Register />} />
            </>
          )}
          {user && (
            <>
              <Route path="/meme/:id" element={<MemeEdit />} />
              <Route path="/create" element={<MemeEdit />} />
            </>
          )}
          <Route path="/profile/:id" element={<Profile />} />
          {user?.role === "admin" && (
            <Route path="/admin" element={<AdminDashboard />} />
          )}
          <Route path="*" element={<NotFound />} />
        </Routes>
      </main>
      <Footer />
    </div>
  );
}

export default App;
