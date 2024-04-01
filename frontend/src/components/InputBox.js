import { FaTrash } from "react-icons/fa";

export default function InputBox({ inputBox, setInputBoxes }) {
  function handleChange(e) {
    setInputBoxes((prev) =>
      prev.map((box) =>
        box.id === inputBox.id ? { ...box, text: e.target.value } : box
      )
    );
  }

  function handleDelete(e) {
    e.preventDefault();
    setInputBoxes((prev) => prev.filter((box) => box.id !== inputBox.id));
  }

  function handleFontSizeChange(e) {
    setInputBoxes((prev) =>
      prev.map((box) =>
        box.id === inputBox.id ? { ...box, font_size: e.target.value } : box
      )
    );
  }

  return (
    <div>
      <div className="flex gap-6">
        <div className="relative grow">
          <input
            className="w-full p-8 placeholder:text-zinc-400 text-white bg-transparent border-zinc-400 border-white border-4 rounded-2xl placeholder:text-gray flex-1 lg:text-xl lg:border-2 lg:py-4 lg:px-6 lg:rounded-lg"
            type="text"
            placeholder="Write text here..."
            value={inputBox.text}
            onChange={handleChange}
          />
          <button
            className="absolute top-1/2 transform -translate-x-8 -translate-y-1/2"
            onClick={handleDelete}
          >
            <FaTrash className="text-red-500" />
          </button>
        </div>
        <div>
          <select
            value={inputBox.font_size}
            className="p-8 placeholder:text-zinc-400 text-white bg-transparent border-zinc-400 border-white border-4 rounded-2xl placeholder:text-gray flex-1 lg:text-xl lg:border-2 lg:py-4 lg:px-6 lg:rounded-lg"
            onChange={handleFontSizeChange}
          >
            <option className="text-black" value="sm">
              SM
            </option>
            <option className="text-black" value="base">
              Base
            </option>
            <option className="text-black" value="lg">
              LG
            </option>
            <option className="text-black" value="xl">
              XL
            </option>
            <option className="text-black" value="2xl">
              2XL
            </option>
            <option className="text-black" value="3xl">
              3XL
            </option>
            <option className="text-black" value="4xl">
              4XL
            </option>
            <option className="text-black" value="5xl">
              5XL
            </option>
          </select>
        </div>
      </div>
    </div>
  );
}
