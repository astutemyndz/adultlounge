import React from 'react'
import StripeCheckout from 'react-stripe-checkout';
const SubscribePackage = () => {

    const handleToken = (token, addresses) => {
        console.log({token, addresses});
    }
    return (
        <div className="credit-list">
            <h3>6 Months</h3>
            <h2>£99.90</h2>
            <p>Lorem Ipsum is simply dummy text</p>
            {/* <a href="http://localhost/adultlounge/process-payment/4q2VolejRejNmGQB" className="btn">SUBSCRIBE</a> */}
            <StripeCheckout 
                stripeKey={"pk_test_9X1Edj5lTitMBPOAzC1Q2xcV"}
                token={handleToken}
                name="Adult Lounge" // the pop-in header title
                description="Cams & Escorts" // the pop-in header subtitle
                image="http://localhost/adultlounge/assets/images/logo.png" // the pop-in header image (default none)
                ComponentClass="div"
                panelLabel="Pay Now" // prepended to the amount in the bottom pay button
                amount={1} // cents
                currency="EUR"
                locale="UK"
                email="dev.rakesh2k14@gmail.com"
                // Note: Enabling either address option will give the user the ability to
                // fill out both. Addresses are sent as a second parameter in the token callback.
                shippingAddress={false}
                billingAddress={false}
                // Note: enabling both zipCode checks and billing or shipping address will
                // cause zipCheck to be pulled from billing address (set to shipping if none provided).
                zipCode={false}
                //alipay // accept Alipay (default false)
                //bitcoin // accept Bitcoins (default false)
                allowRememberMe // "Remember Me" option (default true)
                //opened={this.onOpened} // called when the checkout popin is opened (no IE6/7)
                //closed={this.onClosed} // called when the checkout popin is closed (no IE6/7)
                // Note: `reconfigureOnUpdate` should be set to true IFF, for some reason
                // you are using multiple stripe keys
                reconfigureOnUpdate={false}
                // Note: you can change the event to `onTouchTap`, `onClick`, `onTouchStart`
                // useful if you're using React-Tap-Event-Plugin
                //triggerEvent="onTouchTap"
 
            />
        </div>
    )
}
export default SubscribePackage