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
        url: "https://i.imgflip.com/30b1gx.jpg",
        inputBoxes: [
          { id: 0, text: "n3ich 3adi", x: 194, y: -156, fontSize: "3xl" },
          {
            id: 1,
            text: "projet web lifestyle",
            x: 142,
            y: 114,
            fontSize: "3xl",
          },
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
