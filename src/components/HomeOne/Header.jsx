import React, { useEffect, useState, useCallback } from 'react';
import { Link } from 'react-router-dom';
import useScrollPosition from "../../lib/useScrollPosition";
import logo1 from '../../assets/images/logo1.png';
import Stickylogo from '../../assets/images/logo1.png';
import Navigation from '../Navigation.jsx';
import MobileMenu from '../MobileMenu.jsx';
import { Link as ScrollLink } from "react-scroll";
import * as Scroll from "react-scroll";

function Header({ className = '', scroll = false}) {
    const [menuState, setMenuState] = useState({
        isMobileMenuOpen: false,
        isSearchPopupOpen: false,
    });
    const isSticky = useScrollPosition(100);

    const toggleMenu = useCallback((menuType) => {
        setMenuState((prev) => ({
          ...prev,
          [menuType]: !prev[menuType],
        }));
    }, []);

    const closeMenu = useCallback((menuType) => {
        setMenuState((prev) => ({
          ...prev,
          [menuType]: false,
        }));
    }, []);

    return (
        <header className={`main-header header-style-four ${className || ''}`}>
            {/* <!-- Header Lower --> */}
            <div className="header-lower">
                <div className="auto-container">
                    {/* <!-- Main box --> */}
                    <div className="main-box">
                        <div className="logo-box">
                            <div className="logo">
                                <Link to="/"><img src={logo1} alt=""/></Link>
                            </div>
                        </div>
                        <div className="nav-outer">
                            <nav className="nav main-menu">
                                <Navigation />
                            </nav>
                            <div className="outer-box">
                                <div className="btn-box">
                                    <ScrollLink to="getQuote" smooth={true} duration={500} className="theme-btn btn-style-one bg-light"><span className="btn-title">GET A QUOTE</span></ScrollLink>
                                </div>

                                {/* <!-- Mobile Nav toggler --> */}
                                <div className="mobile-nav-toggler" onClick={() => toggleMenu('isMobileMenuOpen')}><span className="icon lnr-icon-bars"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {/* <!-- End Header Lower --> */}

            {/* <!-- Mobile Menu  --> */}
            <div className={`mobile-menu ${menuState.isMobileMenuOpen ? 'open' : ''}`}>
                <div className="menu-backdrop" onClick={() => closeMenu('isMobileMenuOpen')} />

                <nav className="menu-box">
                    <div className="upper-box">
                        <div className="nav-logo">
                            <Link to="/">
                                <img src={logo1} alt=""/>
                            </Link>
                        </div>
                        <div className="close-btn" onClick={() => closeMenu('isMobileMenuOpen')}><i className="icon fa fa-times"></i></div>
                    </div>

                    <ul className="navigation clearfix">
                        <MobileMenu/>
                    </ul>
                    <ul className="contact-list-one">
                        <li>
                            <i className="icon lnr-icon-phone-handset"></i>
                            <span className="title">Call Now</span>
                            <div className="text"><a href="tel:07055990728">+234 (0) 7055990728</a>, <a href="tel:07055990729">+234 (0) 7055990729 </a></div>
                        </li>
                        <li>
                            <i className="icon lnr-icon-envelope1"></i>
                            <span className="title">Send Email</span>
                            <div className="text"><a href="mailto:info@incomeelectrix.com
">info@incomeelectrix.com</a></div>
                        </li>
                        <li>
                            <i className="icon lnr-icon-map-marker"></i>
                            <span className="title">Address</span>
                            <div className="text">POWER HOUSE<br/>
Km 16, Port Harcourt-Aba Expressway
Port Harcourt, Rivers State – Nigeria.</div>
                        </li>
                    </ul>
                    <ul className="social-links">
                        <li><Link to="#"><i className="fab fa-twitter"></i></Link></li>
                        <li><Link to="#"><i className="fab fa-facebook-f"></i></Link></li>
                        <li><Link to="#"><i className="fab fa-pinterest"></i></Link></li>
                        <li><Link to="#"><i className="fab fa-instagram"></i></Link></li>
                    </ul>
                </nav>
            </div>

            {/* <!-- Header Search --> */}
            <div className={`search-popup ${menuState.isSearchPopupOpen ? 'active' : ''}`}>
                <span className="search-back-drop" onClick={() => closeMenu('isSearchPopupOpen')} />
                <button className="close-search" onClick={() => closeMenu('isSearchPopupOpen')}>
                    <span className="fa fa-times"></span>
                </button>

                <div className="search-inner">
                    <form method="get" action="/">
                        <div className="form-group">
                            <input type="search" name="search-field" placeholder="Search..."/>
                            <button type="submit"><i className="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div className={`sticky-header ${isSticky ? "fixed-header" : ""} animated slideInDown' : ''}`}>
                <div className="auto-container">
                    <div className="inner-container">
                        <div className="logo">
                            <Link to="/"><img src={Stickylogo} alt=""/></Link>
                        </div>
                        <div className="nav-outer">
                            <nav className="main-menu">
                                <div className="navbar-collapse show collapse clearfix">
                                    <ul className="navigation clearfix">
                                        <Navigation/>
                                    </ul>
                                </div>
                            </nav>

                            {/* <!--Mobile Navigation Toggler--> */}
                            <div className="mobile-nav-toggler" onClick={() => toggleMenu('isMobileMenuOpen')}>
                                <span className="icon lnr-icon-bars"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

    );
}

export default Header;