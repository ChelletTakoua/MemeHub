import React from "react";
import Card from "../components/Card";
import BackToTop from "../components/BackToTopButton";

const Home = () => {
  return (
      <div className="min-h-screen w-screen bg-nightgreen">
          <header className="text-center py-20 bg-gradient-to-r from-greens-200 to-nightgreen shadow-2xl text-white">
              <h1 className="text-5xl mb-5">Welcome to MemeHub!</h1>
              <p className="text-xl">Enjoy the best memes from around the world</p>
          </header>
          <Card/>
          <Card/>
          <BackToTop/>
          <footer className="p-5 bg-greens-200 text-white text-center">
              <p>© 2023 MemeHub. All rights reserved.</p>
          </footer>
      </div>

  );
};

export default Home;
