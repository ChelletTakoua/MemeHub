import { useNavigate } from "react-router-dom";

export default function OptionsMenu({ memeResultImg, template }) {
  const navigate = useNavigate();
  function handleDownload() {
    const dataUrl = `data:image/jpeg;base64,${memeResultImg}`;
    var link = document.createElement("a");
    link.download = "meme.jpeg";
    link.href = dataUrl;
    link.click();
  }

  function handleUseTemplate() {
    navigate(`/create`, { state: { template } });
  }

  return (
    <div className="absolute top-0 left-14 mt-2 w-48 bg-gray-300 border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg">
      <div className="px-4 py-3">
        <p className="text-sm">Select an option</p>
      </div>
      <div className="py-1">
        <button
          onClick={handleDownload}
          className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
        >
          download meme
        </button>
        <button
          onClick={handleUseTemplate}
          className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
        >
          use template
        </button>
      </div>
    </div>
  );
}
