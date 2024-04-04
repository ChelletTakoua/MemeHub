import OptionsButton from "./OptionsButton";
import ReportButton from "./ReportButton";
import LikeButton from "./LikeButton";
import ShareButton from "./ShareButton";
import { useContext, useEffect, useState } from "react";
import MemeImg from "./MemeImg";
import Moment from "react-moment";
import { userApi } from "../services/api";
import { AppContext } from "../context/AppContext";
import ReportBox from "./ReportBox";
import { useNavigate } from "react-router-dom";

export default function Card({ meme }) {
  const [showReport, setShowReport] = useState(false);
  const [username, setUsername] = useState("");
  const [profilePic, setProfileImage] = useState("");

  const { user } = useContext(AppContext);
  const navigate = useNavigate();

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
  }, [setProfileImage, setUsername, meme?.user_id]);

  const handleReportClick = () => {
    setShowReport(!showReport);
  };

  const handleProfileClick = () => {
    navigate(`/profile/${meme?.user_id}`);
  };

  return (
    <div className="flex justify-center">
      <div className="flex flex-col justify-between shadow-lg bg-gray-700 rounded-3xl relative ">
        <div className="flex items-center px-6 py-4">
          <img
            onClick={handleProfileClick}
            src={`data:image/jpeg;base64,${profilePic}`}
            alt="user"
            className="rounded-full h-12 w-12 object-cover cursor-pointer"
          />
          <div className="flex flex-col ml-4">
            <p className="text-gray-700 text-base ml-2"></p>
            <p
              className="text-zinc-100 font-bold cursor-pointer"
              onClick={handleProfileClick}
            >
              {username}
            </p>
            <p className="text-gray-400">
              <Moment fromNow>{new Date(meme?.creation_date)}</Moment>
            </p>
          </div>
          <OptionsButton
            memeResultImg={meme?.result_img}
            template={meme?.template}
          />
        </div>
        <div className="flex justify-center items-center py-2 px-4">
          <MemeImg
            key={meme?.id}
            image={`data:image/jpeg;base64,${meme?.result_img}`}
          />
        </div>

        <div className="px-6 pb-4 pt-8">
          <div className="flex items-center">
            <LikeButton
              memeId={meme?.id}
              likes={meme?.nb_likes}
              userLikedIt={meme.liked}
            />
            <ShareButton />
            {user && <ReportButton onReportClick={handleReportClick} />}
          </div>
          <ReportBox
            memeId={meme.id}
            showReport={showReport}
            setShowReport={setShowReport}
          />
        </div>
      </div>
    </div>
  );
}
