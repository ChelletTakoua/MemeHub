import * as htmlToImage from "html-to-image";

export default function DownloadBtn() {
  function download() {
    htmlToImage
      .toPng(document.querySelector("#meme"), { quality: 1 })
      .then(function (dataUrl) {
        var link = document.createElement("a");
        link.download = "meme.jpeg";
        link.href = dataUrl;
        link.click();
      });
  }

  return (
    <button
      onClick={download}
      className="active:scale-95 hover:scale-105 focus:scale-105 transition-transform p-8 text-4xl lg:text-xl lg:py-4 lg:px-6 text-white bg-gradient-to-r from-algae to-grass shadow-2xl rounded-2xl lg:rounded-lg"
    >
      Download Meme
    </button>
  );
}
