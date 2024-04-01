import React, { useContext, useEffect } from "react";
import { Route, Routes, useLocation } from "react-router-dom";
import Navbar from "./components/Navbar";
import Home from "./pages/Home";
import Login from "./pages/Login";
import Register from "./pages/Register";
import AdminDashboard from "./pages/AdminDashboard";
import MemeEdit from "./pages/MemeEdit";
import Profile from "./pages/Profile";
import About from "./pages/AboutUs";
import VerifyEmail from "./pages/VerifyEmail";
import Footer from "./components/Footer";
import { AppContext } from "./context/AppContext";
import "./App.css";
import NotFound from "./pages/NotFound";

function App() {
  const { user, checkAuth } = useContext(AppContext);

  useEffect(() => {
    checkAuth();
  }, [checkAuth]);

  const location = useLocation();
  const hideNavbar = (location.pathname === "/verifyEmail") || (location.pathname === "/resetPassword");

  

  return (
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
