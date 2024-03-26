import OptionsButton from "./OptionsButton";
import ReportButton from "./ReportButton";
import LikeButton from "./LikeButton";
import ShareButton from "./ShareButton";
import { useState } from "react";
import { BsFillSendFill } from "react-icons/bs";

export default function Card({ user, meme, profilePic, date, index }) {
  const [showReport, setShowReport] = useState(false);

  const handleReportClick = () => {
    setShowReport(!showReport);
  };

  return (
    <div className="flex justify-center">
      <div className="w-1/2 shadow-lg bg-gray-700 rounded-3xl relative">
        <div className="flex items-center px-6 py-4">
          <img src={profilePic} alt="user" className="rounded-full" />
          <p className="text-gray-700 text-base ml-2">
            <p className="text-zinc-100 font-bold">{user}</p>{" "}
            <p className="text-gray-400">on {date}</p>
          </p>
          <OptionsButton memeId={`meme-${index}`} />
        </div>
        <img src={meme} id={`meme-${index}`} alt="random" className="w-full" />
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
      </div>
    </div>
  );
}
