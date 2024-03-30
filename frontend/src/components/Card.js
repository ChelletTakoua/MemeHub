import OptionsButton from "./OptionsButton";
import ReportButton from "./ReportButton";
import LikeButton from "./LikeButton";
import ShareButton from "./ShareButton";
import {useRef, useState} from "react";
import { Transition } from 'react-transition-group';
import { BsFillSendFill } from "react-icons/bs";

export default function Card({ user, meme, profilePic, date }) {
  const [showReport, setShowReport] = useState(false);
  const reportRef = useRef(null);

  const handleReportClick = () => {
    setShowReport(!showReport);
  };

  const defaultStyle = {
    transition: `height 500ms ease-in-out, opacity 500ms ease-in-out`,
    height: '0px',
    opacity: 0,
    overflow: 'hidden'
  };

  const transitionStyles = {
    entering: { height: '0px', opacity: 0 },
    entered:  { height: reportRef.current ? `${reportRef.current.scrollHeight}px` : '0px', opacity: 1 },
    exiting:  { height: reportRef.current ? `${reportRef.current.scrollHeight}px` : '0px', opacity: 1 },
    exited:  { height: '0px', opacity: 0 },
  };


  return (
    <div className="flex justify-center mt-10">
      <div className="w-1/2 shadow-lg bg-gray-700 rounded-3xl  relative ">
        <div className="flex items-center px-6 py-4">
          <img src={profilePic} alt="user" className="rounded-full" />
          <div className="flex flex-col ml-4">
            <p className="text-gray-700 text-base ml-2"></p>
            <p className="text-zinc-100 font-bold">{user}</p>
            <p className="text-gray-400">on {date}</p>
          </div>
          <OptionsButton memeId={meme?.id} />
        </div>
        <img src={meme} id={meme?.id} alt={meme?.title} className="w-full" />
        <div className={`px-6 py-4`}>
          <div className="flex items-center">
            <LikeButton />
            <ShareButton />
            <ReportButton onReportClick={handleReportClick} />
          </div>
          <Transition in={showReport} timeout={100}>
            {state => (
                <div ref={reportRef} style={{
                  ...defaultStyle,
                  ...transitionStyles[state]
                }} className="mt-4 flex flex-row justify-end space-x-5 items-start report-container">
                <textarea
                    className="p-2 rounded w-1/2 h-20 border-black border-2 bg-gray-300"
                    placeholder="Write a report..."
                />
                  <button className="mt-2 p-2 text-greens-200 text-2xl hover:text-greens-300 active:text-nightgreen">
                    <BsFillSendFill />
                  </button>
                </div>
            )}
          </Transition>
        </div>
      </div>
    </div>
  );
}