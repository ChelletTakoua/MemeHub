import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faHeart } from "@fortawesome/free-solid-svg-icons";
import { faGithub } from "@fortawesome/free-brands-svg-icons";

export default function Footer() {
  return (
    <footer className="shrink-0 text-lg flex justify-between py-8 px-12 bg-algae shadow-2xl lg:px-44">
      <p>
        Made with <FontAwesomeIcon icon={faHeart} color="red" /> by
        ChelletTakoua
      </p>
      <p className="w-1/3">© 2024 MemeHub. All rights reserved. </p>
      <a target="_blank" href="https://github.com/ChelletTakoua/MemeHub/">
        <FontAwesomeIcon icon={faGithub} size="xl" color="white" />
      </a>
    </footer>
  );
}
