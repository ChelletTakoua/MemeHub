import React from "react";
import Card from "../components/Card";

const Home = () => {
  return (
      <div className="dark:bg-palenight min-h-screen w-screen">
          <header className="text-center py-20 bg-blue-300 text-white">
              <h1 className="text-5xl mb-5">Welcome to MemeHub!</h1>
              <p className="text-xl">Enjoy the best memes from around the world</p>
          </header>
          <Card/>
          <Card/>
          <p>This is the home page.</p>
      </div>
  );
};

export default Home;
