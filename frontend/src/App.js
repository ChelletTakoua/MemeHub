import React, { useContext, useEffect } from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Navbar from "./components/Navbar";
import Home from "./pages/Home";
import Login from "./pages/Login";
import Register from "./pages/Register";
import AdminDashboard from "./pages/AdminDashboard";
import MemeEdit from "./pages/MemeEdit";
import Profile from "./pages/Profile";
import Contact from "./pages/ContactUs";
import Footer from "./components/Footer";
import { AppContext } from "./context/AppContext";
import "./App.css";

function App() {
  const { user } = useContext(AppContext);

  return (
    <div className="app">
      <Navbar />
      <main className="app-main">
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/contact" element={<Contact />} />
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
          <Route path="/admin" element={<AdminDashboard />} />
          <Route path="/profile/:id" element={<Profile />} />
          <Route path="*" element={<h1>Not Found</h1>} />
        </Routes>
      </main>
      <Footer />
    </div>
  );
}

export default App;
