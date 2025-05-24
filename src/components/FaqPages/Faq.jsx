import React, { useState } from 'react';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';

function Faq({ className }) {
   // Manage the state to track which accordion is open
   const [activeIndex, setActiveIndex] = useState(null);
   const [activeIndex2, setActiveIndex2] = useState(null);

   // Toggle function for accordion items
   const toggleAccordion = (index) => {
       setActiveIndex(activeIndex === index ? null : index);
   };
   // Toggle function for accordion items
   const toggleAccordion2 = (index2) => {
       setActiveIndex2(activeIndex2 === index2 ? null : index2);
   };

   // Accordion data
   const faqsLeft = [
       {
           question: "What warranties do I have for installation?",
           answer: "There are many variations of passages of available, but the majority have suffered alteration in some form."
       },
       {
           question: "What is included in your services?",
           answer: "There are many variations of passages of available, but the majority have suffered alteration in some form."
       },
       {
           question: "What are the payment methods?",
           answer: "There are many variations of passages of available, but the majority have suffered alteration in some form."
       },
       {
           question: "How fast I get my order?",
           answer: "There are many variations of passages of available, but the majority have suffered alteration in some form."
       },
   ];
   // Accordion data
   const faqsRight = [
       {
           question: "Produce Your Own Clean Save The Environment",
           answer: "Reduce, reuse, and recycle: This is a classic but effective way to reduce waste and conserve resources. Try to use reusable bags, containers, and water bottles, and recycle items that can't be reused."
       },
       {
           question: "On-Site Service And Support For Certification",
           answer: "Reduce, reuse, and recycle: This is a classic but effective way to reduce waste and conserve resources. Try to use reusable bags, containers, and water bottles, and recycle items that can't be reused."
       },
       {
           question: "Light Source For Stable Conversion Efficiency",
           answer: "Reduce, reuse, and recycle: This is a classic but effective way to reduce waste and conserve resources. Try to use reusable bags, containers, and water bottles, and recycle items that can't be reused."
       },
       {
           question: "Do You Give Guarantee And After Sales Service?",
           answer: "Reduce, reuse, and recycle: This is a classic but effective way to reduce waste and conserve resources. Try to use reusable bags, containers, and water bottles, and recycle items that can't be reused."
       },
   ];

    return (
        <>
        <InnerHeader />
        <PageTitle
            title="Faq"
            breadcrumb={[
                { link: '/', title: 'Home' },
                { link: '/faq', title: 'Faq' },
            ]}
        />
        <section className="faqs-section-home1 mt-0 pt-120 pb-60 pb-md-20">
            <div className="auto-container">
                <div className="row">
                    <div className="faq-column col-lg-6">
                        <div className="inner-column">
                            <ul className="accordion-box wow fadeInLeft">
                                {faqsLeft.map((faqLeft, index) => (
                                <li key={index} className={`accordion block ${activeIndex === index ? 'active-block' : ''}`} >
                                    <div className={`acc-btn ${activeIndex === index ? 'active' : ''}`} onClick={() => toggleAccordion(index)}>{faqLeft.question}<div className="icon fa fa-plus"/></div>
                                    <div className={`acc-content ${activeIndex === index ? 'current' : ''}`}>
                                        <div className="content"><div className="text">{faqLeft.answer}</div></div>
                                    </div>
                                </li>
                                ))}
                            </ul>
                        </div>
                    </div>
                    <div className="faq-column col-lg-6">
                        <div className="inner-column mb-md-50">
                            <ul className="accordion-box style-two bg-transparent p-0 wow fadeInLeft">
                                {faqsRight.map((faqRight, index2) => (
                                <li key={index2} className={`accordion block ${activeIndex2 === index2 ? 'active-block' : ''}`} >
                                    <div className={`acc-btn ${activeIndex2 === index2 ? 'active' : ''}`} onClick={() => toggleAccordion2(index2)}>{faqRight.question}<div className="icon fa fa-plus"/></div>
                                    <div className={`acc-content ${activeIndex2 === index2 ? 'current' : ''}`}>
                                        <div className="content"><div className="text">{faqRight.answer}</div></div>
                                    </div>
                                </li>
                                ))}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <Footer />
        <BackToTop />
        </>
    );
}

export default Faq;
