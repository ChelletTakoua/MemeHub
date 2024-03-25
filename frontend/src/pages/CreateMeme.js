import { useState, useEffect } from "react";
import Header from "../components/Header";
import Browse from "../components/Browse";
import Meme from "../components/Meme";
import Footer from "../components/Footer";

export default function CreateMeme() {
  const [browse, setBrowse] = useState(true);
  const [memes, setMemes] = useState([]);
  const [currMeme, setCurrMeme] = useState({});

  useEffect(() => {
    fetch("https://api.imgflip.com/get_memes")
      .then((data) => data.json())
      .then(({ data }) => {
        setMemes(data.memes);
      });
  }, []);

  return (
    <div className="flex flex-col justify-between dark:bg-palenight min-h-screen w-screen">
      {browse ? (
        <Browse memes={memes} setCurrMeme={setCurrMeme} setBrowse={setBrowse} />
      ) : (
        <Meme currMeme={currMeme} setBrowse={setBrowse} />
      )}
      <Footer />
    </div>
  );
}
