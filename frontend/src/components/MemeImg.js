import DraggableText from "./DraggableText";

export default function MemeImg({ memeData, inputBoxes, setInputBoxes }) {
  return (
    <div id="meme" className="relative flex-1">
      <img src={memeData.url} alt="Meme" className="w-full aspect-square" />

      {inputBoxes?.map((inputBox) => (
        <DraggableText
          key={inputBox.id}
          inputBox={inputBox}
          setInputBoxes={setInputBoxes}
        />
      ))}
    </div>
  );
}
