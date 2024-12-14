import { useState } from "react";
import Bookmarks from "./bookmark";


const Box = () => {
    const [trigger, setTrigger] = useState(false);
    const [inputValueLink, setInputValueLink] = useState("");
    const [inputValueTitle, setInputValueTitle] = useState("");

    const createBookmark = () => {
        const bookmark = { link: inputValueLink, title: inputValueTitle }; // Use state directly
        return bookmark;
    }

    // Reset the input value
    const resetInput = () => {
        setInputValueLink("");
        setInputValueTitle(""); // Reset state to an empty string
    };

    const [data, setData] = useState([]);

    const handelButtonClick = async () => {
        resetInput();
        const bookmark = createBookmark();
        const body = { "link": bookmark.link, "title": bookmark.title };
        try {
            const response = await fetch(`http://localhost:3000/api/create.php`,
                { method: 'POST', body: JSON.stringify(body), },);
            if (!response.ok) {
                throw new Error("error cannot fetch data");
            }
            const respObj = await response.json();
            setData(respObj);
            console.log(data);
            setTrigger(!trigger);
        } catch (error) {
            console.error("Error fetching data:", error);
        }

    }


    return (
        <div className='main-bar'>
            <input
                className="link-input"
                value={inputValueLink}
                onChange={(e) => setInputValueLink(e.target.value)} // Update state on input change
                placeholder="Enter the Link"
            />

            <input
                className="title-input"
                value={inputValueTitle}
                onChange={(e) => setInputValueTitle(e.target.value)} // Update state on input change
                placeholder="Enter the Title"
            />
            <button className="add-button" onClick={handelButtonClick} >Add Bookmark</button>
            <Bookmarks trigger={trigger} />

        </div>
    )

}

export default Box;