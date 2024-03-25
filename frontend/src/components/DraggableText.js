import React from "react";
import Draggable from "react-draggable";

const DraggableText = ({ inputBox, setInputBoxes }) => {
  const handleStopDrag = (e, data) => {
    const { x, y } = data;
    console.log({ e, data });
    setInputBoxes((prev) =>
      prev.map((box) => (box.id === inputBox.id ? { ...box, x, y } : box))
    );
  };
  return (
    <Draggable
      bounds="parent"
      axis="both"
      defaultPosition={{ x: 0, y: 0 }}
      position={{ x: inputBox.x, y: inputBox.y }}
      onStop={handleStopDrag}
    >
      <div
        className={`bottom-80 left-1/3 cursor-grab meme-text text-${inputBox.fontSize} font-mono text-white w-fit relative`}
      >
        {inputBox.text}
      </div>
    </Draggable>
  );
};

export default DraggableText;
