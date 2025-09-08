import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import AboutImg1 from '../../assets/images/kilowatt/about1.jpg';
import AboutImg2 from '../../assets/images/kilowatt/about2.jpg';
import Popup from 'reactjs-popup';
import PopupBox from '../PopupBox.jsx';
const imgPath = '/src/assets/images/kilowatt/';

function About({ className }) {

    const [isOpen, setOpen] = useState(false); 

    const handleOpen = () => {
        setOpen(true);
    };
    
    const handleClose = () => {
        setOpen(false);
    };
    
    const ApiUrl = import.meta.env.VITE_API_URL;
    const [data, setData] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [dataLoaded, setDataLoaded] = useState(false);
    
    useEffect(() => {
        const fetchData = async () => {
          try {
            const response = await fetch(ApiUrl + "kilowatt/getHomeAbout");
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


    return (
        <>
            <section id="kilowattAbout" className={`about-section-five ${className || ''}`}>
                <div className="shape-23 bounce-y"/>
                <div className="auto-container kilowatt">
                    <div className="row">
                        <div className="content-column col-xl-6 col-lg-7 order-2 wow fadeInRight" data-wow-delay="600ms">
                            <div className="inner-column">
                                <div className="sec-title kilowatt">
                                    <span className="sub-title">{data.kilowatt_about_icon_title}</span>
                                    <h2>{data.kilowatt_about_title}</h2>
                                    <div className="text">
                                    <div dangerouslySetInnerHTML={{ __html: data.kilowatt_about_snippet }} />
                                        {/*Kilowatt Engineering Limited (KEL) powers lives and businesses with innovation and an unwavering drive for excellence, driven by a mission to redefine customer experience, spend reduction and sustainability while being the provider of choice wherever energy is consumed. 
                                    <br/><br/>
                                    KEL provides end-to-end  Utility Management solutions, from program conceptualization to design, procurement, construction, commissioning, operations, maintenance and management of electric power system, with added expertise of the repairs and maintenance electrical equipment. */} 

                                    </div>
                                </div>
                                {/*<ul className="list-style-three">
                                    <li>How to Benefited G Shop</li>
                                    <li>electrik other Services</li>
                                    <li>product making for friendly users</li>
                                    <li>We maintaining Safety</li>
                                </ul>*/}
                                <div className="btn-box">
                                    {/*<Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">DISCOVER MORE</span></Link>*/}
<Popup
        trigger={<a className="theme-btn kilowatt btn-style-one bg-dark"><span className="btn-title">DISCOVER MORE</span></a>}
        modal
      >
        {close => (
          <PopupBox className="kilowatt" title="About Kilowatt Engineering Limited" content={<div className="aboutContent kilowatt">
            <div dangerouslySetInnerHTML={{ __html: data.kilowatt_about_full_content }} />
            {/*
            Kilowatt Engineering Limited (KEL) powers lives and businesses with innovation and an unwavering drive for excellence, driven by a mission to redefine customer experience, spend reduction and sustainability while being the provider of choice wherever energy is consumed. 
            <br/><br/>
            KEL provides end-to-end  Utility Management solutions, from program conceptualization to design, procurement, construction, commissioning, operations, maintenance and management of electric power system, with added expertise of the repairs and maintenance electrical equipment.  
            <br/><br/>
            <b>Our Mission</b>
            <br/>
            To be the preferred provider of power distribution solutions in Nigeria to the satisfaction of all stakeholders.
            <br/><br/>

            <b>Our Vision</b>
            <br/>
            To provide customized power distribution solutions that deliver value to our esteemed customers through innovation, diligence and technology. 
            <br/><br/>

            <b>Our Vision</b>
            <br/>
            <ul>
                <li>Integrity</li>
                <li>Safety</li>
                <li>Empathy</li>
                <li>Responsiveness</li>
                <li>Value-Driven</li>
                <li>Excellence</li>
            </ul>*/}</div>
            } onClose={close} classProp='header kilowatt' classClose='close kilowatt' />
        )}
      </Popup>


                                    <a href="tel:11(0000)1111" className="info-btn"> <i className="icon fa fa-phone"></i> <small>Call Anytime</small> <strong>07055990710                                    </strong> </a>
                                </div>
                            </div>
                        </div>
                        <div className="image-column col-xl-6 col-lg-5">
                            <div className="inner-column">
                                <figure className="image-1 overlay-anim wow fadeInUp"><img src={imgPath + data.kilowatt_about_left_pic} alt="Image"/>
                                </figure>
                                <figure className="image-2 overlay-anim wow fadeInRight"><img src={imgPath + data.kilowatt_about_right_pic}  alt="Image"/>
                                </figure>
                                <div className="experience bounce-y">
                                    <strong>{data.kilowatt_about_experience_years}+</strong>
                                    <div className="text">Years Work Experience</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default About;
