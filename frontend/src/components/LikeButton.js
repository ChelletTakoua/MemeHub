import React, { useContext, useState } from "react";
import { useSpring, animated } from "react-spring";
import { IoMdHeartEmpty, IoMdHeart } from "react-icons/io";
import { memeApi } from "../services/api";
import { AppContext } from "../context/AppContext";

export default function LikeButton({ memeId, nbLikes }) {
  const [liked, setLiked] = useState(false);
  const [likes, setLikes] = useState(nbLikes);

  const { user } = useContext(AppContext);

  const handleClick = async () => {
    if (!liked) {
      await memeApi.likeMeme(memeId);
    } else {
      await memeApi.dislikeMeme(memeId);
    }
    setLikes((likes) => (liked ? likes - 1 : likes + 1));
    setLiked((liked) => !liked);
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
      <span className="ml-1 text-1xl">{likes} likes</span>
    </div>
  );
}
