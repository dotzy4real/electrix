// MobileMenu.jsx
import { useState } from "react";
import { Link } from "react-router-dom"; // Ensure correct import for react-router-dom

const MobileMenu = () => {
    const [menuState, setMenuState] = useState({
        activeMenu: null,
        activeSubMenu: null
    });

    const handleMenuClick = (key) => {
        setMenuState(prev => ({
            ...prev,
            activeMenu: prev.activeMenu === key ? null : key
        }));
    };
    
    const handleSubMenuClick = (key) => {
        setMenuState((prev) => ({
            ...prev,
            activeSubMenu: prev.activeSubMenu === key ? null : key,
        }));
    };

    return (
        <>

        <ul className="navigation">
            <li>
                <Link to="/">Home</Link>
                {/*<ul className={menuState.activeMenu === 1 ? "d-block" : "d-none"}>
                    <li><Link to="/">Home page 01</Link></li>
                    <li><Link to="/index-2">Home page 02</Link></li>
                    <li><Link to="/index-3">Home page 03</Link></li>
                    <li><Link to="/index-4">Home page 04</Link></li>
                    <li><Link to="/index-5">Home page 05</Link></li>
                </ul>
                <div className={menuState.activeMenu === 1 ? "dropdown-btn active" : "dropdown-btn"} onClick={() => handleMenuClick(1)} >
                    <i className="fa fa-angle-down"></i>
                </div>*/}
            </li>
            <li className="dropdown">
                <Link to="#">About Us</Link>
                <ul className={menuState.activeMenu === 2 ? "d-block" : "d-none"}>
                            <li><Link to="/who-we-are">Who We Are</Link></li>
                            <li><Link to="/board-members">Board Members</Link></li>
                            <li><Link to="/management-team">Management Team</Link></li>
                            <li><Link to="/careers">Careers</Link></li>
                </ul>
                <div className={menuState.activeMenu === 2 ? "dropdown-btn active" : "dropdown-btn"} onClick={() => handleMenuClick(2)}>
                    <i className="fa fa-angle-down"></i>
                </div>
            </li>
            <li className="dropdown">
                <Link to="#">Services</Link>
                <ul className={menuState.activeMenu === 3 ? "d-block" : "d-none"}>                    
                    <li><Link to="/what-we-do">What We Do</Link></li>
                    <li><Link to="/what-we-have-done">What We Have Done</Link></li>
                </ul>
                <div className={menuState.activeMenu === 3 ? "dropdown-btn active" : "dropdown-btn"} onClick={() => handleMenuClick(3)} >
                    <i className="fa fa-angle-down"></i>
                </div>
            </li>
            <li className="dropdown">
                <Link to="#">Blog</Link>
            </li>
            <li><Link to="/contact">Contact</Link></li>
        </ul>

        </>
    );
};

export default MobileMenu;