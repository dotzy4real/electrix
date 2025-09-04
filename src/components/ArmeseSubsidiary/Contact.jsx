import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import ContactImage from '../../assets/images/resource/expert-group.png';


function Contact({ className }) {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [contact, setContact] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "armese/getOpeningHours");
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
            <section className={`contact-section-three style-three ${className || ''}`}>
                <div className="auto-container">
                    <div className="row">
                        <div className="content-column col-lg-6 col-md-12 col-sm-12 order-2">
                            <div className="inner-column wow fadeInRight">
                                <div className="sec-title light">
                                    <div className="sub-title">CONTACT US</div>
                                    <h2>Contact Us Let’s Talk Your Any Query.</h2>
                                </div>

                                <div className="info-box-outer">
                                    <div className="time-table-box">
                                        <div className="inner">
                                            <h4 className="title">Opening Hour</h4>
                                            <ul>
                                            
      {data.map(item => (
            <li key={item.armese_opening_hour_id}>{item.armese_opening_hour_name} <span className="time-table">{item.armese_opening_hour_time}</span></li>

        ))}
{/*
                                                <li>Mon-Fri <span className="time-table">9am - 6pm</span></li>
                                                <li>Sat <span className="time-table">9am - 6pm</span></li>
                                                <li>Sun <span className="time-table">Closed</span></li>*/}
                                            </ul>
                                        </div>
                                    </div>

                                    <div className="contact-details-info">
                                        <div className="inner">
                                            <h3>Visit Our Location</h3>
                                            <div className="contact-details-block">
                                                <div className="inner-box ">
                                                    <i className="icon fa fa-phone"></i>
                                                    <div className="title">Looking For Consultation</div>
                                                    <div className="text">{contact.armese_contact_info_phone}  {/*(234) 803 727 2707, (234) 908 735 7690*/}
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="contact-details-block">
                                                <div className="inner-box ">
                                                    <i className="icon fa fa-map-marker-alt"></i>
                                                    <div className="title">Visit Our Location</div>
                                                    <div className="text">{contact.armese_contact_info_address}{/*Km 16, PH/ Aba Expressway, 
Rumuokwrushi,
Port Harcourt,
Rivers State. */}
</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {/*
                                <div className="expert-info-box">
                                    <figure className="image"><img src={ContactImage} alt="Image"/></figure>
                                    <div className="expert-number">+12</div>
                                    <div className="expert-text">We collaborated with <span>150+</span> new start-up</div>
                                </div>*/}
                            </div>
                        </div>
                        <div className="form-column col-lg-6 col-md-12 col-sm-12">
                            <div className="inner-column">
                                <div className="contact-form-two wow fadeInLeft">
                                    <div className="title-box">
                                        <h3>Have Any Questions</h3>
                                        <span className="sub-title">Feel free to contact us through anywhere.</span>
                                    </div>
                                    <form method="post" action="get" id="contact-form">
                                        <div className="row gx-3">
                                            <div className="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="text" name="full_name" placeholder="Your Name" required/>
                                            </div>

                                            <div className="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="email" name="Email" placeholder="Email Name" required/>
                                            </div>

                                            <div className="form-group col-lg-12 col-md-12 col-sm-12">
                                                <input type="text" name="website" placeholder="Website" required/>
                                            </div>

                                            <div className="form-group col-lg-12 col-md-12 col-sm-12">
                                                <textarea name="message" placeholder="Your Comment" required></textarea>
                                            </div>

                                            <div className="form-group col-lg-12 col-md-12 col-sm-12">
                                                <button className="theme-btn btn-style-one hvr-light" type="submit" name="submit-form"><span className="btn-title">GET SOLUTION</span></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Contact;
