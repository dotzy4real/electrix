import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/contact_us.png';
const imgPath = '/src/assets/images/resource/pagebanners';

function Contact() {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [contact, setContact] = useState([]);
const [dataLoaded, setDataLoaded] = useState(false);
const [phones, setPhones] = useState([]);

useEffect(() => {
	const fetchData = async () => {
	  try {
		const response = await fetch(ApiUrl + "electrix/getPage/contact");
		if (!response.ok) {
		  throw new Error(`HTTP error! status: ${response.status}`);
		}
		const result = await response.json();
		console.log(result);
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
		  const response = await fetch(ApiUrl + "electrix/getContactInfo");
		  if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		  }
		  const result = await response.json();
		  setContact(result);
		  const phoneNos = result.contact_info_phone.split(",");
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

	
	const [fullName, setFullName] = useState('');
	const [email, setEmail] = useState('');
	const [phone, setPhone] = useState('');
	const [subject, setSubject] = useState('');
	const [message, setMessage] = useState('');
	const [statusMessage, setStatusMessage] = useState("");

	  
	const handleSubmit = async (e) => {
		e.preventDefault();
		//if (!validate()) return;
	
		const data = new FormData();
		data.append('full_name', fullName);
		data.append('email', email);
		data.append('phone', phone);
		data.append('subject', subject);
		data.append('message', message);
		console.log("form data: " + JSON.stringify(data));
		try {
		  const response = await fetch(ApiUrl + "electrix/sendContactMessage", {
			method: 'POST',
			body: data
			// Do NOT set 'Content-Type' header when using FormData
		  });
		  console.log(response);
		  const result = await response.json();
		  console.log('Success:', result);
		  if (result.error == "")
		  {
			  setFullName("");
			  setPhone("");
			  setEmail("");
			  setSubject("");
			  setMessage("");
			  alert('Contact Message Sent Successfully!');
		  }
		  else
			  alert("An error occured when submitting your contact message");
		  setStatusMessage(result.statusMessage);
		} catch (error) {
		  console.error('Error submitting form:', error);
		  setStatusMessage("<div class='alert alert-danger alert-dismissible fade show' role='alert'>An Internal Error Occured when submitting your form</div>");
		}
	};


    return (
        <>
        <InnerHeader />
        <PageTitle
	        title="Contact Us"
	        breadcrumb={[
	            { link: '/', title: 'Home' },
	            { title: data.page_breadcumb_title },
	        ]}
			banner={imgPath+"/"+data.page_banner}
	    />
	  	{/* <!--Contact Details Start--> */}
	  	<section className="contact-details">
	  		<div className="container ">
	  			<div className="row">
	  				<div className="col-xl-7 col-lg-6">
	  					<div className="sec-title">
	  						<span className="sub-title">Send us email</span>
	  						<h2>Feel free to write</h2>
	  					</div>
	  					<form id="contact_form" onSubmit={handleSubmit}>
	  						<div className="row">
				  <div className='col-md-12'><div dangerouslySetInnerHTML={{ __html: statusMessage }} /></div>
	  							<div className="col-sm-6">
	  								<div className="mb-3">
	  									<input name="full_name" className="form-control" value={fullName || ''} onChange={(e) => setFullName(e.target.value)} type="text" placeholder="Enter Name" required/>
	  								</div>
	  							</div>
	  							<div className="col-sm-6">
	  								<div className="mb-3">
	  									<input name="email" value={email || ''}  onChange={(e) => setEmail(e.target.value)} className="form-control required email" type="email" placeholder="Enter Email" required/>
	  								</div>
	  							</div>
	  						</div>
	  						<div className="row">
	  							<div className="col-sm-6">
	  								<div className="mb-3">
	  									<input name="subject" value={subject || ''}  onChange={(e) => setSubject(e.target.value)} className="form-control required" type="text" placeholder="Enter Subject" required/>
	  								</div>
	  							</div>
	  							<div className="col-sm-6">
	  								<div className="mb-3">
	  									<input name="phone" value={phone || ''}  onChange={(e) => setPhone(e.target.value)} pattern="^\+?[0-9]{8,15}$" required className="form-control" type="text" placeholder="Enter Phone"/>
	  								</div>
	  							</div>
	  						</div>
	  						<div className="mb-3">
	  							<textarea name="message" value={message || ''} onChange={(e) => setMessage(e.target.value)} className="form-control required" rows="7" placeholder="Enter Message" required></textarea>
	  						</div>
	  						<div className="mb-5">
	  							<input name="form_botcheck" className="form-control" type="hidden" value="" />
	  							<button type="submit" className="theme-btn btn-style-two mb-3 mb-sm-0 me-3" data-loading-text="Please wait..."><span className="btn-title">Send message</span></button>
	  							<button type="reset" className="theme-btn btn-style-two"><span className="btn-title">Reset</span></button>
	  						</div>
	  					</form>
	  				</div>
	  				<div className="col-xl-5 col-lg-6">
	  					<div className="contact-details__right">
	  						<div className="sec-title">
	  							<span className="sub-title">{data.page_icon_title}</span>
	  							<h2>{data.page_title}</h2>
	  							<div className="text">
									
								  <div dangerouslySetInnerHTML={{ __html: data.page_content }} />
									{/*Have questions or need assistance?
<br/><br/>
We're here to help. Reach out to us by filling the form on this page and we will get back to you with the assistance you need.*/}</div>
	  						</div>
	  						<ul className="list-unstyled contact-details__info">
	  							<li className="d-block d-sm-flex align-items-sm-center ">
	  								<div className="icon">
	  									<span className="lnr-icon-phone-plus"></span>
	  								</div>
	  								<div className="text ml-xs--0 mt-xs-10">
	  									<h6>Have any question?</h6>
										  {phones.map((item, index) => ( <a key={item.trim()} href={"tel:"+item.trim()}>{item}{index < phones.length-1? ",":""}</a> ))}
	  									{/*<a href="tel:07055990728">+234 (0) 7055990728</a>, <a href="tel:07055990729">+234 (0) 7055990729 </a>*/}
	  								</div>
	  							</li>
	  							<li className="d-block d-sm-flex align-items-sm-center ">
	  								<div className="icon">
	  									<span className="lnr-icon-envelope1"></span>
	  								</div>
	  								<div className="text ml-xs--0 mt-xs-10">
	  									<h6>Write email</h6>
	  									<a href={"mailto:"+contact.contact_info_email}>{contact.contact_info_email}</a>
	  								</div>
	  							</li>
	  							<li className="d-block d-sm-flex align-items-sm-center ">
	  								<div className="icon">
	  									<span className="lnr-icon-location"></span>
	  								</div>
	  								<div className="text ml-xs--0 mt-xs-10">
	  									<h6>Visit anytime</h6>
	  									<div><div dangerouslySetInnerHTML={{ __html: contact.contact_info_address }} />{/*POWER HOUSE<br/>
Km 16, Port Harcourt-Aba Expressway<br/>
Port Harcourt, Rivers State – Nigeria.*/}</div>
	  								</div>
	  							</li>
	  						</ul>
	  					</div>
	  				</div>
	  			</div>
	  		</div>
	  	</section>
		{/* <!--Contact Details End--> */}

		{/* <!-- Map Section--> */}
		<section className="map-section">
			<iframe className="map w-100" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=1%20Grafton%20Street,%20Dublin,%20Ireland+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
		</section>
		{/* <!--End Map Section--> */}
        <Footer />
        <BackToTop />
        </>
    );
}

export default Contact;
