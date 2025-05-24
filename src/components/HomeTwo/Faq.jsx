import React from 'react';
import Accordion from '../../lib/Accordion';
import RangeSlider2 from '../../lib/RangeSlider2.jsx';
import FaqImage from '../../assets/images/resource/float-img-2.png';
import FaqBgImage from '../../assets/images/background/13.jpg';


function Faq({ className }) {
    return (
        <>

    {/* <!-- Faq's Section --> */}
	<section className="faq-section-two">
	  <div className="bg bg-image" style={{ backgroundImage: `url(${FaqBgImage})` }}/>
	  <div className="float-image wow zoomInRight animated"><img src={FaqImage} alt="Image"/></div>
	  <div className="auto-container">
	    <div className="outer-box">
	      <div className="row align-items-center"> 
	        <div className="faq-column col-xl-6 col-lg-5 order-lg-2 wow fadeInRight" data-wow-delay="300ms">
	          <div className="inner-column">
	            <div className="sec-title"> <span className="sub-title">CAPABILITIES</span>
	              <h2>Services that help our customers meet</h2>
	              <div className="text">With over four decades of experience providing solutions to large-scale <br />
	                enterprises throughout the globe, we offer end-to-end.</div>
	            </div>
	            <Accordion />
	          </div>
	        </div>
	        <div className="form-column col-lg-6 wow fadeInLeft">
	          <div className="inner-column"> 
	            <div className="contact-form style-two wow fadeInLeft">
	              <div className="bg bg-pattern-1"/>
	              <h3 className="title">Request A Quote</h3>
	              <form method="post" action="get" id="contact-form">
	                <div className="row">
	                  <div className="form-group col-lg-6 col-md-6">
	                    <input type="text" name="first_name" placeholder="First Name" required/>
	                  </div>
	                  <div className="form-group col-lg-6 col-md-6">
	                    <input type="text" name="last_name" placeholder="Last Name" required/>
	                  </div>
	                  <div className="form-group col-lg-6 col-md-6">
	                    <input type="text" name="email" placeholder="Email" required/>
	                  </div>
	                  <div className="form-group col-lg-6 col-md-6">
	                    <input type="text" name="phone" placeholder="Phone" required/>
	                  </div>
	                  <div className="form-group col-lg-6 col-md-6">
	                    <input type="text" name="company" placeholder="Company" required/>
	                  </div>
	                  <div className="form-group col-lg-6 col-md-6">
	                    <input type="text" name="address" placeholder="Address" required/>
	                  </div>
	                  <div className="form-group col-lg-12">
	                    <label>Budget Range</label>
	                    <RangeSlider2/>
	                  </div>
	                  <div className="form-group col-lg-12">
	                    <textarea name="form_message" className="form-control required" rows="5" placeholder="Message"></textarea>
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
	{/* <!-- End Faq's Section --> */}
        </>
    );
}

export default Faq;
