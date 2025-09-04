import React, { useState } from 'react';
import Popup from 'reactjs-popup';
import { Link } from 'react-router-dom';

function PopupBox({ title, content, onClose, classProp, classClose }) {
    const [isOpen, setOpen] = useState(false); 
    
    return (
        <>
            <div className="modalPop">
		<div className="headerTop">
        <div className={classProp}> {title}</div>
        <button className={classClose} onClick={onClose}>
          &times;
        </button></div>
        <div className="content">
            {content}
        </div>
      </div>
        </>
    );
}

export default PopupBox;
