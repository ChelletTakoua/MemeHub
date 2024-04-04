import DraggableText from "./DraggableText";

export default function MemeImg({
  image,
  inputBoxes = null,
  setInputBoxes = null,
  onClick = null,
  page = null,
}) {
  return (
    <div
      id="meme"
      className={
        page === "home"
          ? "flex-1 relative"
          : "flex-1 relative flex flex-col items-center justify-center rounded-lg"
      }
    >
      <img
        id="drag-bounds"
        src={image}
        alt="Meme"
        className={page === "home" ? "w-full" : "w-full rounded-lg"}
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
