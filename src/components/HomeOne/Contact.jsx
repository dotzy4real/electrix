import React, { useEffect, useState } from 'react';
import RangeSlider2 from '../../lib/RangeSlider2.jsx';
import ContactBgImage from '../../assets/images/background/3.jpg';
import ContactBgImage1 from '../../assets/images/background/4.jpg';


function Contact({ className }) {


const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [features, setFeatures] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getFeature");
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
          const response = await fetch(ApiUrl + "electrix/getFeatureLists");
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const result = await response.json();
          setFeatures(result);
        } catch (error) {
          setError(error);
        } finally {
          setLoading(false);
          setDataLoaded(true);
        }
      };
  
      fetchData();
    }, []);
    
    const [firstName, setFirstName] = useState('');
    const [lastName, setLastName] = useState('');
    const [email, setEmail] = useState('');
    const [phone, setPhone] = useState('');
    const [company, setCompany] = useState('');
    const [address, setAddress] = useState('');
    const [message, setMessage] = useState('');
    const [statusMessage, setStatusMessage] = useState("");

      
    const handleSubmit = async (e) => {
        e.preventDefault();
        //if (!validate()) return;
    
        const data = new FormData();
        data.append('first_name', firstName);
        data.append('last_name', lastName);
        data.append('email', email);
        data.append('phone', phone);
        data.append('company', company);
        data.append('address', address);
        data.append('message', message);
        console.log("form data: " + JSON.stringify(data));
        console.log("First Name: " + data.get('first_name'));
        try {
          const response = await fetch(ApiUrl + "electrix/sendRequestQuote", {
            method: 'POST',
            body: data
            // Do NOT set 'Content-Type' header when using FormData
          });
          console.log(response);
          const result = await response.json();
          console.log('Success:', result);
          if (result.error == "")
          {
              setFirstName("");
              setLastName("");
              setCompany("");
              setEmail("");
              setPhone("");
              setAddress("");
              setMessage("");
              alert('Quote Request Sent Successfully!');
          }
          else
              alert("An error occured when submitting your quote request");
          setStatusMessage(result.statusMessage);
        } catch (error) {
          console.error('Error submitting form:', error);
          setStatusMessage("<div class='alert alert-danger alert-dismissible fade show' role='alert'>An Internal Error Occured when submitting your form</div>");
        }
    };

    return (
        <>
            <section id="getQuote" name="getQuote" className={`contact-section ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${ContactBgImage})` }}/>
                <div className="auto-container">
                    <div className="outer-box">
                        <div className="row">
                            <div className="content-column col-lg-6 col-md-12 col-sm-12 order-lg-2">
                                <div className="inner-column wow fadeInRight">
                                    <div className="sec-title light">
                                        <span className="sub-title">FEATURES</span>
                                        <h2>{data.feature_title}</h2>
                                        <div className="text">{data.feature_snippet}</div>
                                    </div>

                                    {features.map(item => (

                                    <div key={item.feature_list_id} className="feature-block-two">
                                        <div className="inner-box"> <i className="icon flaticon-011-hand-drill"></i>
                                            <div className="content">
                                                <h5 className="title">{item.feature_list_title}</h5>
                                                <div className="text">{item.feature_list_snippet}</div>
                                            </div>
                                        </div>
                                    </div>
                                    ))}

{/*
                                    <div className="feature-block-two">
                                        <div className="inner-box"> <i className="icon flaticon-011-hand-drill"></i>
                                            <div className="content">
                                                <h5 className="title">Expert Electricians</h5>
                                                <div className="text">We have the world best electricians in the world to meet up your electrical needs</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="feature-block-two">
                                        <div className="inner-box"> <i className="icon flaticon-017-wrench"></i>
                                            <div className="content">
                                                <h5 className="title">Dedicated Team</h5>
                                                <div className="text">We work together as a cross functional team to deliver world best solutions</div>
                                            </div>
                                        </div>
                                    </div>
*/}

                                </div>
                            </div>
                            <div className="form-column col-lg-6 col-md-12 col-sm-12">
                                <div className="bg bg-image" style={{ backgroundImage: `url(${ContactBgImage1})` }}/>
                                <div className="inner-column">
                                    <div className="contact-form wow fadeInLeft">
                                        <div className="bg bg-pattern-1"></div>
                                        <h3 className="title">Request A Quote</h3>
                                        <form id="quote_form" onSubmit={handleSubmit}>
                                            <div className="row">
                                            <div className='col-md-12'><div dangerouslySetInnerHTML={{ __html: statusMessage }} /></div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="first_name" value={firstName || ''} onChange={(e) => setFirstName(e.target.value)} placeholder="First Name" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="last_name" value={lastName || ''} onChange={(e) => setLastName(e.target.value)} placeholder="Last Name" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="email" name="email" value={email || ''}  onChange={(e) => setEmail(e.target.value)} placeholder="Email" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="phone" value={phone || ''}  onChange={(e) => setPhone(e.target.value)} pattern="^\+?[0-9]{8,15}$" placeholder="Phone" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="company" value={company || ''} onChange={(e) => setCompany(e.target.value)} placeholder="Company" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="address" value={address || ''} onChange={(e) => setAddress(e.target.value)} placeholder="Address" required/>
                                                </div>
                                                {/*
                                                <div className="form-group col-lg-12">
                                                    <label>Budget Range</label>
                                                    <RangeSlider2/>
                                                </div>*/}
                                                <div className="form-group col-lg-12">
                                                    <textarea name="message" value={message || ''} onChange={(e) => setMessage(e.target.value)} className="form-control required" rows="5" placeholder="Message" required></textarea>
                                                </div>
                                                <div className="form-group col-lg-12">
                                                    <button type="submit" className="theme-btn btn-style-one hvr-light" name="submit-form"><span className="btn-title">SUBMIT REQUEST</span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
