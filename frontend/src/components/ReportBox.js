import React, { useState, useContext, useRef } from "react";
import { BsFillSendFill } from "react-icons/bs";
import { Transition } from "react-transition-group";
import { AppContext } from "../context/AppContext";
import { memeApi } from "../services/api";

const ReportBox = ({ memeId, showReport, setShowReport }) => {
  const [reportText, setReportText] = useState("");
  const reportRef = useRef(null);
  const { toast } = useContext(AppContext);

  const handleReportTextChange = (event) => {
    setReportText(event.target.value);
  };

  const handleReportSend = async () => {
    try {
      await memeApi.reportMeme(memeId, { report_reason: reportText });
      setReportText("");
      setShowReport(false);
      toast.success("Report sent successfully!");
    } catch (error) {
      toast.error(error?.response.data.message);
    }
  };
  const defaultStyle = {
    transition: `height 500ms ease-in-out, opacity 500ms ease-in-out`,
    height: "0px",
    opacity: 0,
    overflow: "hidden",
  };

  const transitionStyles = {
    entering: { height: "0px", opacity: 0 },
    entered: {
      height: reportRef.current ? `${reportRef.current.scrollHeight}px` : "0px",
      opacity: 1,
    },
    exiting: {
      height: reportRef.current ? `${reportRef.current.scrollHeight}px` : "0px",
      opacity: 1,
    },
    exited: { height: "0px", opacity: 0 },
  };

  return (
    <Transition in={showReport} timeout={100}>
      {(state) => (
        <div
          ref={reportRef}
          style={{
            ...defaultStyle,
            ...transitionStyles[state],
          }}
          className="mt-4 flex flex-row justify-end space-x-5 items-start report-container"
        >
          <textarea
            className="p-2 rounded w-1/2 h-20 border-black border-2 bg-gray-300"
            onChange={handleReportTextChange}
            placeholder="Write a report..."
          />
          {reportText.length !== 0 && (
            <button
              className="mt-2 p-2 text-greens-200 text-2xl hover:text-greens-300 active:text-nightgreen"
              onClick={handleReportSend}
            >
              <BsFillSendFill />
            </button>
          )}
        </div>
      )}
    </Transition>
  );
};

export default ReportBox;
