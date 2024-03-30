import * as htmlToImage from 'html-to-image';

export default function OptionsMenu({ imageId }){
    function download() {
        htmlToImage
            .toPng(document.querySelector(`#${imageId}`), { quality: 1 })
            .then(function (data) {
                console.log(data);
                let link = document.createElement('a');
                link.download = 'meme.png';
                link.href = data;
                link.click();
            });
    }

    return(
        <div className="absolute top-0 left-14 mt-2 w-48 bg-gray-300 border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg">
            <div className="px-4 py-3">
                <p className="text-sm">Select an option</p>
            </div>
            <div className="py-1">
                <button onClick={download} className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">download meme</button>
                <button className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">use as template</button>
            </div>
        </div>
    );
}