import React, {Component} from "react";
import ReactDOM from "react-dom";
import reqwest from "reqwest";
import Rate from "./Rate";
class Attitude extends Component {
    constructor(props) {
        super(props);
		this.state = {
            allRate: parseInt(this.props.allRate),
            totalRate: parseInt(this.props.totalRate),
            allWorth: parseInt(this.props.allWorth),
            totalWorth: parseInt(this.props.totalWorth),
            allBack: parseInt(this.props.allBack),
            totalBack: parseInt(this.props.totalBack),
            userRate: this.props.userRate,
            userWorth: this.props.userWorth,
            userBack: this.props.userBack
        };
	}
    rateChange(rateNum){
        reqwest({
        	url: "../lib/attitude/handler.php",
        	method: "POST",
        	data: {"newRate": rateNum, "parkId1": this.props.parkId},
        	success: function(result) {
                console.log(result);
                if (result == 1) {
                    let newAll = rateNum - this.state.userRate + this.state.allRate;
                    if (this.state.userRate) {
                        this.setState({userRate: rateNum, allRate: newAll});
                    } else {
                        this.setState({userRate: rateNum, allRate: newAll, totalRate: this.state.totalRate + 1});
                    }
                }
            }.bind(this)
        });
    }
    worthChange(choice) {
        let userWorth;
        if (choice === 1 && this.state.userWorth == "0") {
            userWorth = 1;
            this.setState({userWorth: userWorth, allWorth: this.state.allWorth + 1});
        } else if (choice === 1 && this.state.userWorth === null) {
            userWorth = 1;
            this.setState({userWorth: userWorth, allWorth: this.state.allWorth + 1, totalWorth: this.state.totalWorth + 1});
        } else if (choice === 1 && this.state.userWorth == 1) {
            userWorth = null;
            this.setState({userWorth: userWorth, allWorth: this.state.allWorth - 1, totalWorth: this.state.totalWorth -1});
        } else if (choice == 0 && this.state.userWorth == 1) {
            userWorth = "0";
            this.setState({userWorth: userWorth, allWorth: this.state.allWorth - 1});
        } else if (choice == 0 && this.state.userWorth === null) {
            userWorth = "0";
            this.setState({userWorth: userWorth, totalWorth: this.state.totalWorth + 1});
        } else if (choice == 0 && this.state.userWorth == "0") {
            userWorth = null;
            this.setState({userWorth: userWorth, totalWorth: this.state.totalWorth - 1});
        }
        reqwest({
        	url: "../lib/attitude/handler.php",
        	method: "POST",
        	data: {"newWorth": userWorth, "parkId2": this.props.parkId}
        });
    }
    backChange(choice) {
        let userBack;
        if (choice === 1 && this.state.userBack == "0") {
            userBack = 1;
            this.setState({userBack: userBack, allBack: this.state.allBack + 1});
        } else if (choice === 1 && this.state.userBack === null) {
            userBack = 1;
            this.setState({userBack: userBack, allBack: this.state.allBack + 1, totalBack: this.state.totalBack + 1});
        } else if (choice === 1 && this.state.userBack == 1) {
            userBack = null;
            this.setState({userBack: userBack, allBack: this.state.allBack - 1, totalBack: this.state.totalBack -1});
        } else if (choice == 0 && this.state.userBack == 1) {
            userBack = "0";
            this.setState({userBack: userBack, allBack: this.state.allBack - 1});
        } else if (choice == 0 && this.state.userBack === null) {
            userBack = "0";
            this.setState({userBack: userBack, totalBack: this.state.totalBack + 1});
        } else if (choice == 0 && this.state.userBack == "0") {
            userBack = null;
            this.setState({userBack: userBack, totalBack: this.state.totalBack - 1});
        }
        reqwest({
        	url: "../lib/attitude/handler.php",
        	method: "POST",
        	data: {"newBack": userBack, "parkId3": this.props.parkId}
        });
    }
	render() {
        let averageRate = 0;
        if (this.state.totalRate !== 0) {
            averageRate = (this.state.allRate / this.state.totalRate).toFixed(1);
        }
        let worthYes, worthNo;
        if (this.state.userWorth == 1) {
            worthYes = "choice";
        } else if (this.state.userWorth == "0") {
            worthNo = "choice";
        }
        let backYes, backNo;
        if (this.state.userBack == 1) {
            backYes = "choice";
        } else if (this.state.userBack == "0") {
            backNo = "choice";
        }
        let yours;
        if (this.props.userId && this.props.userId != 0) {
            yours = (
                <section className="col-md-12 attitude">
                    <div className="attitude-rate">
                        <h5>Your Rate</h5>
                        <Rate rate={this.state.userRate?this.state.userRate:0} max="5" interact="true" rateChange={this.rateChange.bind(this)} font="22px" />
                    </div>
                    <div className="attitude-title">
                        <h5>
                            Is it worth visiting?
                        </h5>
                        <button className={"vote " + worthYes} onClick={this.worthChange.bind(this, 1)}>Yes</button>
                        <button className={"vote " + worthNo} onClick={this.worthChange.bind(this, 0)}>No</button>
                    </div>
                    <div className="attitude-title">
                        <h5>
                            Will you come back?
                        </h5>
                        <button className={"vote " + backYes} onClick={this.backChange.bind(this, 1)}>Yes</button>
                        <button className={"vote " + backNo} onClick={this.backChange.bind(this, 0)}>No</button>
                    </div>
                </section>
            );
        }
		return (
			<div>
                <section className="col-md-12 attitude">
                    <div className="attitude-rate">
                        <h5>Rate {averageRate} from<br />{this.state.totalRate} Travelers</h5>
                        <Rate rate={averageRate} max="5" font="22px" />
                    </div>
                    <div className="attitude-vote">
                        <h5>
                            ✓ Worthing Visit <br />
                        by {this.state.allWorth + " / " + this.state.totalWorth} Visitors
                        </h5>
                    </div>
                    <div className="attitude-vote">
                        <h5>
                            ✓ Will Come Back<br />
                        by {this.state.allBack + " / " + this.state.totalBack} Visitor
                        </h5>
                    </div>
                </section>
                {yours}
			</div>
		);
	}
}
reqwest({
	url: "../lib/attitude/handler.php",
	method: "POST",
	data: {"parkId": window.location.href.split("?id=").pop()},
	success: function(result) {
        result = JSON.parse(result);
        let allRate = 0, totalRate = 0, allWorth = 0, totalWorth = 0, allBack = 0, totalBack = 0;
        let userId = parseInt(result[1]);
        let userRate = null, userWorth = null, userBack = null;
        if (result[0]) {
            for (let i = 0; i < result[0].length; i++) {
                if (result[0][i].attitude_rate) {
                    totalRate += 1;
                    allRate += parseInt(result[0][i].attitude_rate);
                }
                if (result[0][i].attitude_worth) {
                    if (result[0][i].attitude_worth == 1) {
                        allWorth += 1;
                        totalWorth += 1;
                    } else {
                        totalWorth += 1;
                    }
                }
                if (result[0][i].attitude_back) {
                    if (result[0][i].attitude_back == 1) {
                        allBack += 1;
                        totalBack += 1;
                    } else {
                        totalBack += 1;
                    }
                }
                if (result[0][i].user_id == userId) {
                    userRate = result[0][i].attitude_rate;
                    userWorth = result[0][i].attitude_worth;
                    userBack = result[0][i].attitude_back;
                }
            }
        }
        ReactDOM.render(<Attitude allRate={allRate} totalRate={totalRate} allWorth={allWorth} totalWorth={totalWorth} allBack={allBack} totalBack={totalBack} userRate={userRate} userWorth={userWorth} userId={userId} userBack={userBack} parkId={window.location.href.split("?id=").pop()} />, document.getElementById("attitude-root"));
	}
});
