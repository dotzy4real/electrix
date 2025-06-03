import React from 'react';
import { Link } from 'react-router-dom';
import FeatureImage from '../../assets/images/armese/capabilities1.jpg';

function Process({ className }) {
    return (
        <>

	{/* <!-- Feature Section --> */}
	<section className="feature-section-three">
	  <div className="pattern-7 bounce-x"/>
	  <div className="shape-16"/>
	  <div className="auto-container">
	    <div className="row"> 
	      <div className="content-column col-lg-7">
	        <div className="inner-column">
	          <div className="sec-title light"> <span className="sub-title">CAPABILITIES</span>
	            <h2>Services that help our <br /> Customers meet</h2>
	          </div>
	          <div className="row"> 
	            <div className="feature-block-three col-lg-4 col-sm-6">
                <div className="inner-box"> <i className="icon flaticon-023-telephone-socket"></i>
                  <h5 className="title">Billing System</h5>
                  <div className="text">Involves customer record management, generation of billing data, integration with payment systems 
                  </div>
                </div>
	            </div>
              <div className="feature-block-three col-lg-4 col-sm-6">
                <div className="inner-box"> <i className="icon flaticon-024-socket"></i>
                  <h5 className="title">Token Generation</h5>
                  <div className="text">Fully managed token distribution across multi-channels, identity-based access and password control, remote key loading</div>
                </div>
              </div>
              <div className="feature-block-three col-lg-4 col-sm-6">
                <div className="inner-box"> <i className="icon flaticon-028-pcb-board"></i>
                  <h5 className="title">Optional Vending Channels</h5>
                  <div className="text">Online prepaid vending on dedicated payment, physical prepayment kiosks/offices at strategic locations
                  </div>
                </div>
              </div>
              <Link to="tel:+2348037272707" className="info-btn"> <i className="icon fa fa-phone"></i> <small>Call Anytime</small> <strong>(234) 803 727 2707
              </strong> </Link>
	          </div>
	        </div>
	      </div>
        <div className="image-column col-lg-5">
          <div className="inner-column">
            <div className="image-box">
              <figure className="image rounded overlay-anim reveal"><img src={FeatureImage} alt="Image"/></figure>
            </div>
          </div>
        </div>
	    </div>
	  </div>
	</section>
	{/* <!-- End Feature Section --> */}
        </>
    );
}

export default Process;
