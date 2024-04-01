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

export default function Card({ meme }) {
  const [showReport, setShowReport] = useState(false);
  const [username, setUsername] = useState("");
  const [profilePic, setProfileImage] = useState("");

  const { user } = useContext(AppContext);

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
        <MemeImg
          key={meme?.id}
          image={`data:image/jpeg;base64,${meme?.result_img}`}
        />

        <div className={`px-6 py-4`}>
          <div className="flex items-center">
            <LikeButton memeId={meme?.id} likes={meme?.nb_likes} />
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
