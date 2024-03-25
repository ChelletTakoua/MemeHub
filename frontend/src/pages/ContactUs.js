import React from "react";

const Contact = () => {
  return (
    <div className="bg-gray-800 flex items-center justify-center h-screen text-white">
      <div class="bg-gray-900 shadow-md rounded px-16 pt-12 pb-12 mb-8 flex flex-col">
        <h1 class="mb-4 font-bold text-3xl">Contact Us</h1>
        <p class="mb-8">If you have any questions or inquiries, please send us an email.</p>
        <form action="mailto:chadhagrami1@gmail.com" method="post" enctype="text/plain">
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Send Email
                </button>
            </div>
        </form>
    </div>
    </div>
  );
};

export default Contact;