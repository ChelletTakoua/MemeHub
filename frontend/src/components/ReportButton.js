import { IoIosArrowDown  } from "react-icons/io";
import { useState } from 'react';

export default function ReportButton({ onReportClick }){
    const [showReport, setShowReport] = useState(false);

    const handleClick = () => {
        setShowReport(!showReport);
        onReportClick(showReport);
    }

    return(
        <div className="relative flex items-center ml-auto">
            <button className={`text-4xl text-gray-950 transform transition-transform duration-500 ${showReport ? 'rotate-180' : ''}`} onClick={handleClick}>
                <IoIosArrowDown />
            </button>
        </div>
    );
}