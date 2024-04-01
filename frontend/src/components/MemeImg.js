import DraggableText from "./DraggableText";

export default function MemeImg({
  image,
  inputBoxes = null,
  setInputBoxes = null,
  onClick = null,
}) {
  return (
    <div id="meme" className="relative flex-1">
      <img
        src={image}
        alt="Meme"
        className="w-full aspect-square"
        onClick={onClick}
      />

      {inputBoxes?.map((inputBox, index) => (
        <DraggableText
          key={index}
          inputBox={inputBox}
          setInputBoxes={setInputBoxes}
        />
      ))}
    </div>
  );
}
