import React, { useEffect, useState } from "react";
import Card from "../components/Card";
import BackToTop from "../components/BackToTopButton";
import { memeApi } from "../services/api";

const Home = () => {
  const [memes, setMemes] = useState([]);
  useEffect(() => {
    const fetchMemes = async () => {
      try {
        const res = await memeApi.getAllMemes();
        setMemes(res?.data.data.memes);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };
    fetchMemes();
  }, []);

  return (
    <div className="grow bg-palenight">
      <header className="text-center py-20 bg-gradient-to-r from-greens-200 to-palenight shadow-2xl text-white">
        <h1 className="text-5xl mb-5 animate-ping-once ">
          Welcome to MemeHub!
        </h1>
        <p className="text-xl animate-pulse ">
          Enjoy the best memes from around the world
        </p>
      </header>
      <BackToTop />
      <div className="grid grid-cols-2 mt-10 gap-y-12 gap-x-24  w-2/3 m-auto">
        {memes?.map((meme) => (
          <Card key={meme.id} meme={meme} />
        ))}
      </div>
      <br />
      <br />
    </div>
  );
};

export default Home;
