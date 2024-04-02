import React from "react";

const About = () => {
  return (
    <div className="grow bg-palenight block items-center justify-center text-white">
      <div className="bg-gray-800 shadow-md rounded px-16 pt-12 pb-12 my-8 block mx-96">
        <h1 className="mb-4 font-bold text-3xl justify-center">About Us</h1>
        <p className="mb-8">
          A meme generator and sharing platform where users can create and share
          memes. Users can react to and comment on posts, making it a fun and
          interactive community for meme lovers.
        </p>
      </div>
      <div className="bg-gray-800 shadow-md rounded px-16 pt-12 pb-12 my-8 block mx-96 ">
        <h1 className="mb-4 font-bold text-3xl justify-center ">Contact Us</h1>
        <p className="mb-8">
          If you have any questions or inquiries, please send us an email.
        </p>
        <form
          action="mailto:chellettakoua@gmail.com"
          method="post"
          encType="text/plain"
        >
          <div className="flex items-center justify-center">
            <button
              className="bg-blue-500  hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg focus:outline-none focus:shadow-outline"
              type="submit"
            >
              Send Email
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default About;
