import React from 'react';
import {Link} from 'react-router-dom';
import ProjectThumb1 from '../../assets/images/armese/projects/project1.jpg';
import ProjectThumb2 from '../../assets/images/armese/projects/project2.jpg';
import ProjectThumb3 from '../../assets/images/armese/projects/project3.jpg';
import ProjectThumb4 from '../../assets/images/armese/projects/project4.jpg';
import ProjectThumb5 from '../../assets/images/armese/projects/project5.jpg';
import ProjectThumb6 from '../../assets/images/armese/projects/project6.jpg';

function Footer({ className }) {
    return (
        <>
            <footer className={`main-footer ${className || ''}`}>
                <div className="widgets-section">
                    <div className="auto-container">
                        <div className="row">
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget about-widget">
                                    <h5 className="about-title">About us</h5>
                                    <div className="text">Desires to obtain pain of itself, because it is pain, but occasionally circumstances.</div>
                                    <ul className="social-icon-two">
                                        <li><Link to="#"><i className="fab fa-twitter"></i></Link></li>
                                        <li><Link to="#"><i className="fab fa-instagram"></i></Link></li>
                                        <li><Link to="#"><i className="fab fa-facebook"></i></Link></li>
                                        <li><Link to="#"><i className="fab fa-linkedin-in"></i></Link></li>
                                    </ul>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget">
                                    <h5 className="widget-title">Explore</h5>
                                    <ul className="user-links">
                                        <li><Link to="#">About Company</Link></li>
                                        <li><Link to="#">Meet the Team</Link></li>
                                        <li><Link to="#">News & Media</Link></li>
                                        <li><Link to="#">Our Projects</Link></li>
                                        <li><Link to="#">Contact</Link></li>
                                    </ul>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget contact-widget">
                                    <h5 className="widget-title">Contact</h5>
                                    <div className="widget-content">
                                        <div className="text">Km 16, PH/ Aba Expressway, 
Rumuokwrushi,
Port Harcourt,
Rivers State. 
</div>
                                        <ul className="contact-info">
                                            <li><i className="fa fa-envelope"></i> <Link to="mailto:info@armese.com.ng">info@armese.com.ng
                                            </Link><br /></li>
                                            <li><i className="fa fa-phone-square"></i> <Link to="tel:+2348037272707">(234) 803 727 2707</Link>, <Link to="tel:+2349087357690">(234) 908 735 7690</Link><br /></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget gallery-widget">
                                    <h5 className="widget-title">Gallery</h5>
                                    <div className="widget-content">
                                        <div className="outer clearfix">
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb1} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb2} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb3} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb4} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb5} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb6} alt=""/>
                                                </Link>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="footer-bottom">
                    <div className="auto-container">
                        <div className="inner-container">
                            <div className="copyright-text">&copy; 2025 <Link to="/Armese">Armese</Link> | All Rights Reserved
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </>
    );
}

export default Footer;
