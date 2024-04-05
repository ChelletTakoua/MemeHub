import React, { useContext, useState } from "react";
import { useSpring, animated } from "react-spring";
import { IoMdHeartEmpty, IoMdHeart } from "react-icons/io";
import { memeApi } from "../services/api";
import { AppContext } from "../context/AppContext";

export default function LikeButton({ memeId, likes, userLikedIt = false }) {
  const [liked, setLiked] = useState(userLikedIt);
  const [nbLikes, setNbLikes] = useState(likes);

  const { user } = useContext(AppContext);

  const handleClick = async () => {
    try {
      if (!liked) {
        await memeApi.likeMeme(memeId);
      } else {
        await memeApi.dislikeMeme(memeId);
      }
      setNbLikes((nbLikes) => (liked ? nbLikes - 1 : nbLikes + 1));
      setLiked((liked) => !liked);
    } catch (error) {
      console.error("Error:", error);
    }
  };

  const { scale } = useSpring({
    from: { scale: 1 },
    to: { scale: liked ? 1.3 : 1 },
    reset: true,
    reverse: liked,
    delay: liked ? 250 : 0,
    config: { tension: 250, friction: 50, precision: 0.0001 },
  });

  return (
    <div className="flex items-center">
      <animated.div
        className="hover:cursor-pointer"
        style={{
          transform: scale.to((scale) => `scale(${scale})`),
          display: "inline-block",
        }}
        onClick={handleClick}
      >
        {user &&
          (liked ? (
            <IoMdHeart className="text-red-700 hover:text-red-700 " size={33} />
          ) : (
            <IoMdHeartEmpty className="hover:scale-110" size={33} />
          ))}
      </animated.div>
      <span className="ml-1 text-1xl">{nbLikes} likes</span>
    </div>
  );
}
