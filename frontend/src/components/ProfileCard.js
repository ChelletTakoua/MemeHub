import React, { useState } from "react";
import ReportButton from "../components/ReportButton";
import LikeButton from "../components/LikeButton";
import { FaEdit, FaTrash } from "react-icons/fa";
import { useNavigate } from "react-router-dom";
import MemeImg from "./MemeImg";
import { memeApi } from "../services/api";
import ReportBox from "./ReportBox";

const ProfileCard = ({ isOwner, meme, memes, setMemes }) => {
  const [enlargedImage, setEnlargedImage] = useState(null);
  const [showReport, setShowReport] = useState(false);
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

  const deleteMeme = async () => {
    await memeApi.deleteMeme(meme.id);
    setMemes(memes.filter((m) => m.id !== meme.id));
  };

  const modifyMeme = () => {
    navigate(`/meme/${meme?.id}`);
  };
  return (
    <div className="bg-white bg-opacity-20 rounded-lg shadow-md flex flex-col justify-between">
      <div className="h-full flex justify-center py-2 px-4 ">
        <MemeImg
          key={meme?.id}
          onClick={toggleImageSize}
          image={`data:image/jpeg;base64,${meme?.result_img}`}
        />
      </div>
      {isOwner ? (
        <div className="flex justify-between px-12 py-4 rounded-lg">
          <button
            onClick={deleteMeme}
            className="text-red-500 bg-white bg-opacity-50 shadow-md px-6 py-2 rounded-lg"
            title="Delete Meme"
          >
            <FaTrash />
          </button>
          <button
            onClick={modifyMeme}
            className="text-blue-500 bg-white bg-opacity-50 shadow-md px-6 py-2 rounded-lg"
            title="Modify Meme"
          >
            <FaEdit />
          </button>
        </div>
      ) : (
        <div className="px-6 py-4">
          <div className="flex items-center">
            <LikeButton
              likes={meme.nb_likes}
              memeId={meme.id}
              userLikedIt={meme?.liked}
            />
            <ReportButton onReportClick={handleReportClick} />
          </div>
          <ReportBox
            memeId={meme.id}
            showReport={showReport}
            setShowReport={setShowReport}
          />
        </div>
      )}
    </div>
  );
};

export default ProfileCard;
