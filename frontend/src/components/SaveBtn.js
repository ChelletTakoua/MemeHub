export default function SaveBtn({ onClick }) {
  return (
    <button
      className="active:scale-95 hover:scale-105 focus:scale-105 transition-transform p-8 text-4xl lg:text-xl lg:py-4 lg:px-6 text-white bg-gradient-to-r from-algae to-grass shadow-2xl rounded-2xl lg:rounded-lg"
      onClick={onClick}
    >
      Save Meme
    </button>
  );
}
