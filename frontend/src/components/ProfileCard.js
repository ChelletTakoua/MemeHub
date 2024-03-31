import React, { useState } from "react";
import ReportButton from "../components/ReportButton";
import LikeButton from "../components/LikeButton";
import ShareButton from "../components/ShareButton";
import { BsFillSendFill } from "react-icons/bs";
import { FaEdit, FaTrash } from "react-icons/fa";
import { useNavigate } from "react-router-dom";
import DraggableText from "./DraggableText";
import MemeImg from "./MemeImg";

const ProfileCard = ({ isOwner, meme, memes, setMemes }) => {
  const [showReport, setShowReport] = useState(false);
  const [enlargedImage, setEnlargedImage] = useState(null);
  const [inputBoxes, setInputBoxes] = useState(meme.text_blocks);
  const navigate = useNavigate();

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
    setShowReport((showReport) => !showReport);
  };

  const handleSendReport = () => {
    // Add your report logic here
  };

  const deleteMeme = (memeToDelete) => {
    setMemes(memes.filter((meme) => meme !== memeToDelete));
  };

  const modifyMeme = () => {
    navigate(`/meme/${meme?.id}`);
  };
  return (
    <div className="bg-white rounded-lg shadow-md flex flex-col justify-between ">
      <MemeImg
        key={meme?.id}
        memeData={meme}
        inputBoxes={inputBoxes}
        setInputBoxes={setInputBoxes}
      />
      {isOwner ? (
        <div className="flex justify-between px-12 py-4 ">
          <button
            onClick={deleteMeme}
            className="text-red-500"
            title="Delete Meme"
          >
            <FaTrash />
          </button>
          <button
            onClick={modifyMeme}
            className="text-blue-500"
            title="Modify Meme"
          >
            <FaEdit />
          </button>
        </div>
      ) : (
        <div className="px-6 py-4">
          <div className="flex items-center">
            <LikeButton nbLikes={meme.nb_likes.length} memeId={meme.id} />
            <ShareButton />
            <ReportButton onReportClick={handleReportClick} />
          </div>
          {showReport && (
            <div className="mt-4 flex flex-row  justify-end space-x-5 items-start">
              <textarea
                className="p-2 rounded w-1/2 h-20 border-black border-2 bg-gray-300"
                placeholder="Write a report..."
              />
              <button
                className="mt-2 p-2 text-greens-200 text-2xl hover:text-greens-300 active:text-nightgreen"
                onSubmit={handleSendReport}
              >
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
