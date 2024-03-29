import { useContext, useEffect, useState } from "react";
import InputBox from "./InputBox";
import MemeImg from "./MemeImg";
import DownloadBtn from "./DownloadBtn";
import SaveBtn from "./SaveBtn";
import { FaArrowLeft } from "react-icons/fa";
import { AppContext } from "../context/AppContext";

// currMeme and setBrowse are for creating a new meme
export default function Meme({ currMeme = null, setBrowse = null }) {
  const { user } = useContext(AppContext);

  const [inputBoxes, setInputBoxes] = useState([]);
  useEffect(() => {
    if (currMeme && currMeme.inputBoxes) setInputBoxes(currMeme.inputBoxes);
    else
      setInputBoxes([
        { id: new Date().getTime(), text: "", fontSize: 4, x: 0, y: 0 },
      ]);
  }, [setInputBoxes]);

  // Add a new input box
  function handleAddInputBox(e) {
    e.preventDefault();
    setInputBoxes((prev) => [
      ...prev,
      {
        id: new Date().getTime(),
        text: "",
        fontSize: 4,
        x: 0,
        y: 0,
      },
    ]);
  }

  // Save the meme
  function handleSave() {
    const meme = {
      ...currMeme,
      inputBoxes,
      userid: user.id,
    };
    console.log(meme);
  }

  return (
    <section className="relative">
      {setBrowse && (
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
              memeData={currMeme}
              inputBoxes={inputBoxes}
              setInputBoxes={setInputBoxes}
            />
          </div>
        </div>
        <div className="flex flex-col gap-8 flex-1">
          <form className="flex flex-col gap-8 h-min">
            {inputBoxes.map((inputBox) => (
              <InputBox
                key={inputBox.id}
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
          <p className="text-white">
            Another hint: You can break the line by entering double space!
          </p>
        </div>
      </div>
    </section>
  );
}
