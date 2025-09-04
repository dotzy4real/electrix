import React from 'react';
import BackToTop from '../BackToTop.jsx';
import Footer from './Footer.jsx';
import Banner from './Banner.jsx';
import Service from './Service.jsx';
import Header from './Header.jsx';
import About from './About.jsx';
import Pricing from './Pricing.jsx';
import ChooseUs from './ChooseUs.jsx';
import ChooseUs2 from './ChooseUs2.jsx';
import Team from './Team.jsx';
import HowWeWork from './HowWeWork.jsx';
import Project from './Project.jsx';
import Portfolio from './Portfolio.jsx';
import Project2 from './Project2.jsx';
import Faq from './Faq.jsx';
import Contact2 from './Contact2.jsx';
import Testimonial from './Testimonial.jsx';
import News from './News.jsx';
import Cta from './Cta.jsx';

function HomeFive() {

    return (
        <>
            <Header />
            <Banner />
            {/*<Cta />
            <Project />*/}
            <About />
            <Service />
            <Project2 />
            <HowWeWork />
            {/*<Pricing />
            <ChooseUs2 />*/}
            <Team />
            {/*<News />*/}
            <Contact2 />
            <Footer />
            <BackToTop />
        </>
    );
}

export default HomeFive;
