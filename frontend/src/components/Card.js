import OptionsButton from "./OptionsButton";
import ReportButton from "./ReportButton";
import LikeButton from "./LikeButton";
import ShareButton from "./ShareButton";
import { useContext, useEffect, useRef, useState } from "react";
import { Transition } from "react-transition-group";
import { BsFillSendFill } from "react-icons/bs";
import MemeImg from "./MemeImg";
import Moment from "react-moment";
import { userApi } from "../services/api";
import { AppContext } from "../context/AppContext";

export default function Card({ meme }) {
  const [showReport, setShowReport] = useState(false);
  const [inputBoxes, setInputBoxes] = useState(meme.text_blocks);
  const [username, setUsername] = useState("");
  const [profilePic, setProfileImage] = useState("");
  const reportRef = useRef(null);

  const { user } = useContext(AppContext);

  // fetch user data from the backend
  useEffect(() => {
    const fetchUser = async (id) => {
      try {
        const res = await userApi.getUserProfile(id);
        setUsername(res?.data.data.user.username);
        setProfileImage(res?.data.data.user.profile_pic);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };
    fetchUser(meme?.user_id);
  }, []);

  const handleReportClick = () => {
    setShowReport(!showReport);
  };

  const defaultStyle = {
    transition: `height 500ms ease-in-out, opacity 500ms ease-in-out`,
    height: "0px",
    opacity: 0,
    overflow: "hidden",
  };

  const transitionStyles = {
    entering: { height: "0px", opacity: 0 },
    entered: {
      height: reportRef.current ? `${reportRef.current.scrollHeight}px` : "0px",
      opacity: 1,
    },
    exiting: {
      height: reportRef.current ? `${reportRef.current.scrollHeight}px` : "0px",
      opacity: 1,
    },
    exited: { height: "0px", opacity: 0 },
  };

  return (
    <div className="flex justify-center mt-10">
      <div className="w-1/2 shadow-lg bg-gray-700 rounded-3xl  relative ">
        <div className="flex items-center px-6 py-4">
          <img
            src={`data:image/jpeg;base64,${profilePic}`}
            alt="user"
            className="rounded-full h-12 w-12 object-cover"
          />
          <div className="flex flex-col ml-4">
            <p className="text-gray-700 text-base ml-2"></p>
            <p className="text-zinc-100 font-bold">{username}</p>
            <p className="text-gray-400">
              <Moment fromNow>{meme?.creation_date}</Moment>
            </p>
          </div>
          <OptionsButton memeId={meme?.id} />
        </div>
        <MemeImg key={meme?.id} memeData={meme} inputBoxes={inputBoxes} />
        <div className={`px-6 py-4`}>
          <div className="flex items-center">
            <LikeButton memeId={meme?.id} nbLikes={meme?.nb_likes.length} />
            <ShareButton />
            {user && <ReportButton onReportClick={handleReportClick} />}
          </div>
          <Transition in={showReport} timeout={100}>
            {(state) => (
              <div
                ref={reportRef}
                style={{
                  ...defaultStyle,
                  ...transitionStyles[state],
                }}
                className="mt-4 flex flex-row justify-end space-x-5 items-start report-container"
              >
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
