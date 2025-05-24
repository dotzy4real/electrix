import React from 'react';
import BackToTop from '../BackToTop.jsx';
import Footer from './Footer.jsx';
import Banner from './Banner.jsx';
import Service from './Service.jsx';
import Header from './Header.jsx';
import About from './About.jsx';
import FunFact from './FunFact.jsx';
import ChooseUs from './ChooseUs.jsx';
import Project from './Project.jsx';
import Faq from './Faq.jsx';
import Features from './Features.jsx';
import Contact from './Contact.jsx';
import Testimonial from './Testimonial.jsx';
import News from './News.jsx';
import Cta from './Cta.jsx';

function HomeOne() {

    return (
        <>
            <Header />
            <Banner />
            <Service />
            <About />
            <FunFact />
            {/*<ChooseUs />*/}
            <Project />
            {/*<Faq />*/}
            <Features />
            <Contact />
            {/*<Testimonial />*/}
            <News />
            <Cta />
            <Footer />
            <BackToTop />
        </>
    );
}

export default HomeOne;
