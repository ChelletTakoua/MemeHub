import { useState } from 'react';
import { IoIosArrowDown , IoMdShare } from "react-icons/io";
import LikeButton from "./LikeButton";

export default function Card (){

    return (
        <div className="flex justify-center  m-10">
            <div className="max-w-xl rounded overflow-hidden shadow-lg bg-gray-700 rounded-3xl ">
                <div className="flex items-center px-6 py-4">
                    <img src="https://source.unsplash.com/random/50x50" alt="user" className="rounded-full"/>
                    <p className="text-gray-700 text-base ml-2">
                        <p className="text-zinc-100 font-bold">User</p>  <p className="text-gray-400">on {new Date().toLocaleDateString()}</p>
                    </p>
                </div>
                <img src="https://source.unsplash.com/random" alt="random" className="w-full"/>
                <div className="px-6 py-4">
                    <div className="flex items-center">
                        <LikeButton/>
                        <IoMdShare className="text-gray-300 text-3xl ml-3"/>
                        <button className="ml-auto"><IoIosArrowDown className="text-4xl text-gray-950"/></button>
                    </div>
                    <div className="text-zinc-100 font-bold text-xl mb-2">
                        Meme
                    </div>
                    <p className="text-gray-300 text-base font-light">
                        Description
                    </p>

                </div>
                <div className="px-6 py-4">
                    <span
                        className="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                        #tag1
                    </span>
                    <span
                        className="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                        #tag2
                    </span>
                    <span
                        className="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                        #tag3
                    </span>
                </div>
            </div>
        </div>
    );
}