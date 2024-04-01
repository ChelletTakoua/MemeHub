import React from "react";

const NotFound = () => {
  return (
    <div className="flex center-items grow bg-palenight block items-center justify-center text-white">
      <div className="bg-gray-800 shadow-md rounded-lg px-16 pt-12 pb-12 my-8 block mx-96">
        <h1 className="mb-4 font-bold text-3xl justify-center">
          404 - Page Not Found
        </h1>
        <p className="mb-8">The page you are looking for does not exist.</p>
      </div>
    </div>
  );
};

export default NotFound;
