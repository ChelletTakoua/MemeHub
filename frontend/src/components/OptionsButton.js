import { SlOptionsVertical } from "react-icons/sl";
import { useEffect, useRef, useState } from "react";
import { useTransition, animated } from "react-spring";
import OptionsMenu from "./OptionsMenu";

export default function OptionsButton({ memeResultImg, template }) {
  const [showOptions, setShowOptions] = useState(false);
  const node = useRef();

  // This useEffect is new
  useEffect(() => {
    const handleClickOutside = (e) => {
      if (node.current && node.current.contains(e.target)) {
        return;
      }
      setShowOptions(false);
    };

    document.addEventListener("mousedown", handleClickOutside);

    return () => {
      document.removeEventListener("mousedown", handleClickOutside);
    };
  }, [node]);

  const transitions = useTransition(showOptions, {
    from: { opacity: 0 },
    enter: { opacity: 1 },
    leave: { opacity: 0 },
    config: { duration: 200 },
  });

  const handleClick = () => {
    setShowOptions(!showOptions);
  };

  return (
    <div className="relative flex items-center ml-auto">
      <button className="ml-auto text-2xl" onClick={handleClick}>
        <SlOptionsVertical />
      </button>
      {transitions((style, item) =>
        item ? (
          <animated.div style={style}>
            <OptionsMenu memeResultImg={memeResultImg} template={template} />
          </animated.div>
        ) : null
      )}
    </div>
  );
}
