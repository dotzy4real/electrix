import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { Link as ScrollLink } from "react-scroll";
import ProjectThumb1 from '../../assets/images/armese/projects/project1.jpg';
import ProjectThumb2 from '../../assets/images/armese/projects/project2.jpg';
import ProjectThumb3 from '../../assets/images/armese/projects/project3.jpg';
import ProjectThumb4 from '../../assets/images/armese/projects/project4.jpg';
import ProjectThumb5 from '../../assets/images/armese/projects/project5.jpg';
import ProjectThumb6 from '../../assets/images/armese/projects/project6.jpg';

const imgPath = '/src/assets/images/armese/projects/';

function Footer({ className }) {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [contact, setContact] = useState([]);
const [phones, setPhones] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "armese/getFooterProjects");
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        setData(result);
      } catch (error) {
        setError(error);
      } finally {
        setLoading(false);
        setDataLoaded(true);
      }
    };

    fetchData();
  }, []);


  useEffect(() => {
      const fetchData = async () => {
        try {
          const response = await fetch(ApiUrl + "armese/getContactInfo");
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const result = await response.json();
          setContact(result);
          const phoneNos = result.armese_contact_info_phone.split(",");
          setPhones(phoneNos);
        } catch (error) {
          setError(error);
        } finally {
          setLoading(false);
          setDataLoaded(true);
        }
      };
  
      fetchData();
    }, []);
    console.log("list of footer phones: " + phones);

  
    return (
        <>
            <footer className={`main-footer ${className || ''}`}>
                <div className="widgets-section">
                    <div className="auto-container">
                        <div className="row">
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget about-widget">
                                    <h5 className="about-title">About us</h5>
                                    <div className="text">We specialize in conceptualization; power system engineering consulting and strategy.</div>
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
                                        <li><ScrollLink to="armeseAbout" smooth={true} duration={500}>About Company</ScrollLink></li>
                                        <li><ScrollLink to="armeseTeam" smooth={true} duration={500}>Meet the Team</ScrollLink></li>
                                        <li><ScrollLink to="armeseCapabilities" smooth={true} duration={500}>Our Capabilities</ScrollLink></li>
                                        <li><ScrollLink to="armeseProject" smooth={true} duration={500}>Our Projects</ScrollLink></li>
                                        <li><ScrollLink to="ArmeseContact" smooth={true} duration={500}>Contact</ScrollLink></li>
                                    </ul>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget contact-widget">
                                    <h5 className="widget-title">Contact</h5>
                                    <div className="widget-content">
                                        <div className="text">{contact.armese_contact_info_address}
                                            {/*Km 16, PH/ Aba Expressway, 
Rumuokwrushi,
Port Harcourt,
Rivers State. */}
</div>
                                        <ul className="contact-info">
                                            <li><i className="fa fa-envelope"></i> <Link to={"mailto:"+contact.armese_contact_info_email}>{contact.armese_contact_info_email}
                                            </Link><br /></li>
                                            <li><i className="fa fa-phone-square"></i> 
                                                {phones.map(item => ( <div><a key={item.trim()} href={"tel:"+item.trim()}>{item}</a><br/></div> ))}
                                            {/*<Link to="tel:+2348037272707">(234) 803 727 2707</Link>, <Link to="tel:+2349087357690">(234) 908 735 7690</Link>*/}<br /></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget gallery-widget">
                                    <h5 className="widget-title">Gallery</h5>
                                    <div className="widget-content">
                                        <div className="outer clearfix">
                                            
      {data.map(item => (

        <figure key={item.armese_project_id} className="image">
                                                <Link to="#">
                                                    <img src={imgPath + item.armese_project_pic} alt=""/>
                                                </Link>
                                            </figure>
))}

{/*
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
                                            </figure>*/}
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
