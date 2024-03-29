import { useState, useEffect } from "react";
import Browse from "../components/Browse";
import Meme from "../components/Meme";
import { useParams } from "react-router-dom";

export default function MemeEdit() {
  const [browse, setBrowse] = useState(true);
  const [memes, setMemes] = useState([]);
  const [currMeme, setCurrMeme] = useState({});

  const { id } = useParams("id");

  //-----------------------------
  useEffect(() => {
    if (id) {
      setBrowse(false);
      //setCurrMeme(memes.find((meme) => meme.id === id));
      setCurrMeme({
        id: 1,
        url: "https://i.imgflip.com/1ur9b0.jpg",
        inputBoxes: [
          { id: 0, text: "Malla zaamila", x: 80, y: -44, fontSize: "3xl" },
          { id: 1, text: "Ramdhan ya sa5ta", x: 196, y: -12, fontSize: "3xl" },
        ],
      });
    } else {
      fetch("https://api.imgflip.com/get_memes")
        .then((data) => data.json())
        .then(({ data }) => {
          setMemes(data.memes);
        });
    }
  }, []);
  //-----------------------------

  return (
    <div className="flex flex-col justify-between bg-palenight">
      {browse ? (
        <Browse memes={memes} setCurrMeme={setCurrMeme} setBrowse={setBrowse} />
      ) : (
        <Meme currMeme={currMeme} setBrowse={setBrowse} />
      )}
    </div>
  );
}
