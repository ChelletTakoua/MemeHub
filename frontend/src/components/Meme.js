import { useContext, useEffect, useState } from "react";
import * as htmlToImage from "html-to-image";
import InputBox from "./InputBox";
import MemeImg from "./MemeImg";
import DownloadBtn from "./DownloadBtn";
import SaveBtn from "./SaveBtn";
import { FaArrowLeft } from "react-icons/fa";
import { AppContext } from "../context/AppContext";
import { memeApi } from "../services/api";
import { useNavigate, useParams } from "react-router-dom";

// currMeme and setBrowse are for creating a new meme
export default function Meme({ currMeme = null, setBrowse = null }) {
  const { user } = useContext(AppContext);
  const navigate = useNavigate();
  const { id } = useParams("id");

  const [inputBoxes, setInputBoxes] = useState([]);

  useEffect(() => {
    if (id) {
      setInputBoxes(currMeme?.inputBoxes);
    } else {
      setInputBoxes([
        {
          text: "Modify it!",
          font_size: "2xl",
          x: 0,
          y: 0,
        },
      ]);
    }
  }, [setInputBoxes, id, currMeme?.inputBoxes]);

  // Add a new input box
  function handleAddInputBox(e) {
    e.preventDefault();
    setInputBoxes((prev) => [
      ...prev,
      {
        id: Date.now(),
        text: "",
        font_size: "xl",
        x: 0,
        y: 0,
      },
    ]);
  }

  async function handleSave() {
    const res = await htmlToImage.toPng(document.querySelector("#meme"), {
      quality: 1,
    });
    const result_img = res.split(",")[1];

    if (id) {
      const memeDataUpdate = {
        text_blocks: inputBoxes,
        result_img,
      };
      await memeApi?.modifyMeme(+id, memeDataUpdate);
    } else {
      const memeData = {
        ...currMeme,
        text_blocks: inputBoxes,
        result_img,
      };
      delete memeData.url;
      delete memeData.title;
      delete memeData.inputBoxes;
      await memeApi.addMeme(memeData);
    }
    navigate(`/profile/${user.id}`);
  }

  return (
    <section className="relative">
      {!id && (
        <button
          onClick={() => setBrowse(true)}
          className="absolute top-5 left-48 flex items-center gap-2 justify-center w-40 rounded-full bg-white bg-gradient-to-r from-algae to-grass px-4 py-2 text-white mb-2 text-lg"
        >
          <FaArrowLeft />
          <span>Go Back</span>
        </button>
      )}
      <div className="py-20 mx-12 grid grid-cols-2 gap-14 flex-col lg:flex-row-reverse lg:mx-44">
        <div className="flex flex-col items-start">
          <div>
            <MemeImg
              image={currMeme?.url ? currMeme.url : currMeme?.template?.url}
              inputBoxes={inputBoxes}
              setInputBoxes={setInputBoxes}
            />
          </div>
        </div>
        <div className="flex flex-col gap-8 flex-1">
          <form className="flex flex-col gap-8 h-min">
            {inputBoxes?.map((inputBox, index) => (
              <InputBox
                key={index}
                inputBox={inputBox}
                setInputBoxes={setInputBoxes}
              />
            ))}
            <button
              className="flex items-center gap-2 justify-center w-16 rounded-full bg-white bg-gradient-to-r from-algae to-grass px-4 py-2 text-white text-lg"
              onClick={handleAddInputBox}
            >
              +
            </button>
          </form>
          <div className="flex gap-6 w-full">
            <DownloadBtn />
            <SaveBtn onClick={handleSave} />
          </div>
          <p className="text-white">
            Hint: You can drag and move around the text!
          </p>
        </div>
      </div>
    </section>
  );
}
