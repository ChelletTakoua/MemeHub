import React, { useState } from "react";
import OptionsButton from "../components/OptionsButton";
import ReportButton from "../components/ReportButton";
import LikeButton from "../components/LikeButton";
import ShareButton from "../components/ShareButton";
import { BsFillSendFill } from "react-icons/bs";

const ProfileCard = ({ isOwner, meme, index, memes, setMemes }) => {
  const [showReport, setShowReport] = useState(false);
  const [enlargedImage, setEnlargedImage] = useState(null);

  const toggleImageSize = (event) => {
    const image = event.target;
    if (enlargedImage && enlargedImage !== image) {
      enlargedImage.style.transform = "scale(1.0)";
      enlargedImage.classList.remove("enlarged");
      enlargedImage.style.zIndex = "0";
    }
    if (image.classList.contains("enlarged")) {
      image.style.transform = "scale(1.0)";
      image.classList.remove("enlarged");
      image.style.zIndex = "0";
    } else {
      image.style.transform = "scale(2)";
      image.classList.add("enlarged");
      image.style.zIndex = "1";
      setEnlargedImage(image);
    }
    image.style.transition = "transform 0.3s ease";
  };

  const handleReportClick = () => {
    setShowReport(!showReport);
  };
  const deleteMeme = (memeToDelete) => {
    setMemes(memes.filter((meme) => meme !== memeToDelete));
  };

  const modifyMeme = () => {
    // Add your save logic here
  };
  return (
    <div
      key={index}
      className="bg-white rounded-lg shadow-md flex flex-col justify-between"
    >
      <img
        src={meme}
        alt={`Meme ${index + 1}`}
        className="w-full"
        onClick={toggleImageSize}
      />
      {/* <p className="text-gray-700 mt-2">Meme {index + 1}</p> */}
      {isOwner ? (
        <div className="flex justify-between px-8">
          <button
            onClick={() => deleteMeme(meme)}
            className="mt-2 top-2 right-2 text-black"
            title="Delete Meme"
          >
            🗑️
          </button>
          <button
            onClick={() => modifyMeme(meme)}
            className="mt-2 top-2 right-2 text-black"
            title="Modify Meme"
          >
            🖊️
          </button>
        </div>
      ) : (
        <div className="px-6 py-4">
          <div className="flex items-center">
            <LikeButton />
            <ShareButton />
            <ReportButton onReportClick={handleReportClick} />
          </div>
          {showReport && (
            <div className="mt-4 flex flex-row  justify-end space-x-5 items-start">
              <textarea
                className="p-2 rounded w-1/2 h-20 border-black border-2 bg-gray-300"
                placeholder="Write a report..."
              />
              <button className="mt-2 p-2 text-greens-200 text-2xl hover:text-greens-300 active:text-nightgreen">
                <BsFillSendFill />
              </button>
            </div>
          )}
        </div>
      )}
    </div>
  );
};

export default ProfileCard;
