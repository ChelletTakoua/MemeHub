import React, { useState } from "react";
import ProfileCard from "../components/ProfileCard";

const Profile = ({ isOwner }) => {
  // isOwner = true;

  const [userName, setUserName] = useState("UserName");
  const [Email, setEmail] = useState("Email");
  const [aboutMe, setAboutMe] = useState(
    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem placeat fugit eius debitis, in aspernatur dolorum ea! Laudantium hic distinctio reprehenderit neque labore molestiae quas! Id rerum optio quos quo!"
  );
  const [profileImage, setProfileImage] = useState(
    "https://www.seekpng.com/png/detail/847-8474751_download-empty-profile.png"
  );
  const [memes, setMemes] = useState([
    "https://media.blogto.com/articles/201731-sunrise-ed.jpg?width=1300&quality=70",
    "https://www.telegraph.co.uk/multimedia/archive/03597/potd-london_3597432k.jpg",
    "https://th.bing.com/th/id/R.43b4c6d7ff4da57ead06bae72b2b18b7?rik=Gpz%2fbYGq9r441g&riu=http%3a%2f%2finteriordesignsmagazine.com%2fwp-content%2fuploads%2f2016%2f09%2fPic-1-e1474096677813-940x490.jpg&ehk=YwpCQwfdxmQB3U3fxXmZMmYVjb5magDoxKEkN5uJttI%3d&risl=&pid=ImgRaw&r=0",
    "https://th.bing.com/th/id/R.ed4c5c82883ef4309eb02f8e2417646c?rik=L7mq4JeVSZO0Gw&riu=http%3a%2f%2fradiusblocks.com%2fwp-content%2fuploads%2f2022%2f09%2fimage-grid_3.jpg&ehk=lsdi%2bBpjRQvuIvmtlegfvmYOtqp0reJX%2baon5vAL4F4%3d&risl=&pid=ImgRaw&r=0",
  ]);

  const handleImageUpload = (event) => {
    if (isOwner) {
      setProfileImage(URL.createObjectURL(event.target.files[0]));
    }
  };

  const handleTextChange = (event, setText) => {
    if (isOwner) {
      setText(event.target.value);
    }
  };

  const handleSave = () => {
    // Add your save logic here
  };

  return (
    <div className="bg-palenight min-h-screen w-screen">
      <main className="container mx-auto py-8">
        <div className="flex space-x-8">
          <div className="w-1/4">
            <input
              type="file"
              onChange={handleImageUpload}
              disabled={!isOwner}
              className={`${isOwner ? "" : "hidden"} mb-4`}
            />
            <img
              src={profileImage}
              alt="Profile Picture"
              className="rounded-full w-32 h-32 mx-auto shadow-lg"
            />
            {isOwner ? (
              <input
                value={userName}
                onChange={(e) => handleTextChange(e, setUserName)}
                className="w-full px-3 py-2 mt-4 text-white bg-gray-800 rounded shadow-lg"
              />
            ) : (
              <h2 className="text-2xl font-bold mt-4 text-white">{userName}</h2>
            )}
            <p className="text-gray-300">Joined: January 2022</p>
            <p className="text-gray-300">
              Total Memes Contributed: {memes.length}
            </p>
            <div className="mt-4">
              <h3 className="text-xl font-bold text-white">
                Contact Information
              </h3>
              {isOwner ? (
                <input
                  type="email"
                  value={Email}
                  onChange={(e) => handleTextChange(e, setEmail)}
                  className="w-full px-3 py-2 mt-4 text-white bg-gray-800 rounded shadow-lg"
                />
              ) : (
                <p className="text-gray-300">Email: example@example.com</p>
              )}
            </div>
            {isOwner && (
              <button
                onClick={handleSave}
                type="submit"
                className="px-4 py-2 ml-10 mt-20 text-white bg-blue-800 rounded shadow-lg active:text-gray-500"
              >
                Save Changes
              </button>
            )}
          </div>
          <div className="w-3/4">
            {isOwner ? (
              <>
                <h3 className="text-xl font-bold text-white">About Me</h3>
                <textarea
                  value={aboutMe}
                  onChange={(e) => handleTextChange(e, setAboutMe)}
                  className="w-full px-3 py-2 mt-4 text-white bg-gray-800 rounded shadow-lg"
                />
              </>
            ) : (
              <>
                <h3 className="text-xl font-bold text-white">About Me</h3>
                <p className="text-gray-100 mt-2">{aboutMe}</p>
              </>
            )}

            <div className="w-3/4">
              <h3 className="text-xl font-bold mt-4 text-white">My Memes</h3>
              <div className="grid grid-cols-3 gap-4 mt-2">
                {memes.map((meme, index) => (
                  <ProfileCard
                    key={index}
                    isOwner={isOwner}
                    meme={meme}
                    index={index}
                    memes={memes}
                    setMemes={setMemes}
                  />
                ))}
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  );
};

export default Profile;
