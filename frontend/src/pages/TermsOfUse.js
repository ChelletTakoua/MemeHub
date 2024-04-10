import React from "react";

const TermsOfUse = () => {
  return (
    <div className="bg-gray-900 text-gray-200 min-h-screen flex flex-col justify-center items-center py-12">
      <div className="max-w-6xl bg-gray-800 p-8 rounded-lg shadow-md w-full mx-4">
        <h1 className="text-3xl font-semibold text-gray-200 mb-4">
          Terms of Use
        </h1>
        <p className="text-gray-300 mb-6">
          These Terms of Use govern your access to and use of MemeHub, including
          any content, functionality, and services offered on or through the
          Website.
        </p>
        <h2 className="text-xl font-semibold text-gray-200 mb-2">
          1. Acceptance of Terms
        </h2>
        <p className="text-gray-300 mb-6">
          By accessing or using the Website, you agree to be bound by these
          Terms and our Privacy Policy. If you do not agree to these Terms or
          the Privacy Policy, you must not access or use the Website.
        </p>
        <h2 className="text-xl font-semibold text-gray-200 mb-2">
          2. Use of the Website
        </h2>
        <ul className="list-disc pl-6 text-gray-300 mb-6">
          <li>You must be at least 10 years old to use the Website.</li>
          <li>
            You agree to use the Website only for lawful purposes and in
            accordance with these Terms.
          </li>
          <li>
            You are solely responsible for your use of the Website and any
            content you create or upload.
          </li>
        </ul>
        <h2 class="text-xl font-semibold text-gray-200 mb-2">
          3. User Content
        </h2>
        <p class="text-gray-300 mb-6">
          By creating or uploading content to the Website, you grant us a
          non-exclusive, royalty-free, perpetual, irrevocable, and fully
          sublicensable right to use, reproduce, modify, adapt, publish,
          translate, create derivative works from, distribute, and display such
          content worldwide. You represent and warrant that you have all
          necessary rights to grant us the above license and that your content
          does not violate any third-party rights.
        </p>
        <h2 class="text-xl font-semibold text-gray-200 mb-2">
          4. Prohibited Activities
        </h2>
        <ul class="list-disc pl-6 text-gray-300 mb-6">
          <li>
            Use the Website in any way that violates any applicable laws or
            regulations.
          </li>
          <li>
            Upload, post, or transmit any content that is unlawful, defamatory,
            obscene, pornographic, indecent, offensive, or otherwise
            objectionable.
          </li>
          <li>
            Engage in any activity that interferes with or disrupts the Website
            or the servers and networks connected to the Website.
          </li>
          <li>
            Attempt to gain unauthorized access to any portion of the Website.
          </li>
        </ul>
        <h2 class="text-xl font-semibold text-gray-200 mb-2">
          5. Intellectual Property
        </h2>
        <p class="text-gray-300 mb-6">
          The Website and its entire contents, features, and functionality
          (including but not limited to all information, software, text,
          displays, images, video, and audio, and the design, selection, and
          arrangement thereof) are owned by ChelletTakoua and are protected by
          copyright, trademark, and other intellectual property laws.
        </p>
        <h2 class="text-xl font-semibold text-gray-200 mb-2">
          7. Limitation of Liability
        </h2>
        <p class="text-gray-300 mb-6">
          In no event shall ChelletTakoua be liable for any indirect,
          incidental, special, consequential, or punitive damages, arising out
          of or in connection with your use of the Website.
        </p>
        <h2 class="text-xl font-semibold text-gray-200 mb-2">
          8. Changes to Terms
        </h2>
        <p class="text-gray-300 mb-6">
          We reserve the right to modify these Terms at any time, effective upon
          posting the modified Terms on the Website. Your continued use of the
          Website after any such changes constitutes your acceptance of the
          modified Terms.
        </p>
        <h2 class="text-xl font-semibold text-gray-200 mb-2">
          9. Governing Law
        </h2>
        <p class="text-gray-300 mb-6">
          These Terms shall be governed by and construed in accordance with the
          laws of Tunisia, without regard to its conflict of law principles.
        </p>
        <h2 className="text-xl font-semibold text-gray-200 mb-2">
          10. Contact Us
        </h2>
        <p className="text-gray-300">
          If you have any questions about these Terms, please contact us at{" "}
          <a className="text-primary-400" href="mailto:chellettakoua@gmail.com">
            chellettakoua@gmail.com
          </a>
          .
        </p>
      </div>
    </div>
  );
};

export default TermsOfUse;
