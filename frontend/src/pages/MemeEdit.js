import { useState, useEffect, useContext } from "react";
import Browse from "../components/Browse";
import Meme from "../components/Meme";
import { useLocation, useNavigate, useParams } from "react-router-dom";
import { memeApi, templateApi } from "../services/api";
import { AppContext } from "../context/AppContext";

export default function MemeEdit() {
  const [browse, setBrowse] = useState(true);
  const [memes, setMemes] = useState([]);
  const [currMeme, setCurrMeme] = useState({});
  const navigate = useNavigate();
  const template = useLocation().state?.template;

  const { id } = useParams("id");
  const { user } = useContext(AppContext);

  useEffect(() => {
    const fetchTemplates = async () => {
      try {
        const res = await templateApi.getAllTemplates();
        setMemes(res?.data.data.templates);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };
    const fetchMeme = async (id) => {
      try {
        const res = await memeApi.getMemeById(id);
        if (res?.data.data.meme.user_id !== user.id) navigate("/");
        const memeData = { ...res?.data.data.meme };
        memeData.inputBoxes = res?.data.data.meme.text_blocks;
        delete memeData.text_blocks;
        setCurrMeme(memeData);
      } catch (error) {
        console.error("Error fetching data:", error);
        navigate("/");
      }
    };

    if (id) {
      setBrowse(false);
      fetchMeme(id);
    } else if (template) {
      setBrowse(false);
      template.template_id = template.id; //@yassine zedt el zouz ostra hedhom, ken yab3ath fl addMeme b id fi3oudh template_id
      delete template.id;
      setCurrMeme(template);
    } else {
      fetchTemplates();
    }
  }, [setBrowse, setMemes, setCurrMeme, id, user, navigate, template]);

  return (
    <div className="flex flex-col justify-between bg-palenight">
      {browse ? (
        <Browse memes={memes} setCurrMeme={setCurrMeme} setBrowse={setBrowse} />
      ) : (
        <Meme currMeme={currMeme} setBrowse={setBrowse} />
      )}
    </div>
  );
}
