import React from "react";
import Draggable from "react-draggable";

const DraggableText = ({ inputBox, setInputBoxes = null }) => {
  const handleStopDrag = (e, data) => {
    const { x, y } = data;
    setInputBoxes((prev) =>
      prev.map((box) => (box.id === inputBox.id ? { ...box, x, y } : box))
    );
  };
  return (
    <Draggable
      allowAnyClick={setInputBoxes ? true : false}
      bounds="parent"
      axis="both"
      defaultPosition={{ x: 0, y: 0 }}
      position={{ x: inputBox.x, y: inputBox.y }}
      onStop={handleStopDrag}
    >
      <div
        className={`h-0 bottom-80 left-1/3 cursor-grab meme-text text-${inputBox.font_size} font-mono text-white w-fit relative`}
      >
        {inputBox.text}
      </div>
    </Draggable>
  );
};

export default DraggableText;
