<!-- 2016-Oct-12 PoliScrape HTML Heirarchy -->
<!-- Author: Ryan Steed -->

<?php
// 2016-Oct-12 Steed
// 'New-age' php script that renders the right java code based on the PATH_INFO

include_once('PoliScrape-config.php');

?><!DOCTYPE html>
<meta charset="utf-8">
<html lang="en">

<head>
  <?php include_once("PoliScrape-docs-head.php") ?>
</head>

<body>
    </br>
    <!-- Page Content -->
    <div class="container">
        <?php include_once("button.php") ?>
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 0.5em;">
	    	 <h1>Running the Crawler</h1>
            </div>
        </div>

        <!-- Jumbotron Header -->
        <div class="row">
            <div class="col-lg-12">
            <header class="jumbotron hero-spacer" style="font-size:18px">
                <dl>
                    <dt>Running the Crawler<dt>
                    <dd>
                        <ol type="1">
                            <li><a href="#run">Run Command</a></li>
                            <li><a href="#targeting">Targeting and Scoping</a></li>
                            <li><a href="#html">HTML Parsing</a></li>
                        </ol>
                    </dd>
                </dl>
        </header>
        </div>

        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 1.5em; );
 ">
                <h3 id="run">1. Run Command</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 0.5em; );
 ">
                Currently, there are two crawlers included in the PoliScrape project. The first, named <span class="code">history</span>, targets the State Department's Office of the Historian FRUS collection. The second, called <span class="code">wisconsin</span>, targets Wisconsin's FRUS collection. To run either crawler, navigate to the project home directory, <span class="code">PoliScrape/poliScrapy/foreignScrape</span>. In the command line, run:
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 0.5em; );
 ">
                <header class="jumbotron special" style="font-size:18px;width:35%">
                    <div>scrapy crawl crawlerName</div>
                </header>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 1.5em; );
 ">
                <h3 id="targeting">2. Targeting and Scoping</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 0.5em; );
 ">
                To adjust the first targeted site or volume for a crawler, open the crawler script, located in <span class="code">PoliScrape/poliScrapy/foreignScrape/spiders/spiderName.py</span>. Change or append to the <span class="code">start_urls</span> variable. The <span class="code">allowed_domains</span> variable restricts the base domain searched, and prevents the crawler from straying from the scraping site. Multiple <span class="code">allowed_domains</span> are accepted.
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 0.5em; );
 ">
                <header class="jumbotron special" style="font-size:18px;text-align:left;width:75%">
                    <div>class MySpider(CrawlSpider):<div>
                        <div style="text-indent:40px;">name = 'history'</div>
                        <div style="text-indent:40px;">allowed_domains = ['history.state.gov']</div>
                        <div style="text-indent:40px;">start_urls = ['https://history.state.gov/historicaldocuments/frus1945v01']</div>
                </header>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 1.5em; );
 ">
                <h3 id="html">3. HTML Parsing</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 0.5em;">
                Crawlers scrape specific items from the webpage. These items are defined in <span class="code">PoliScrape/poliScrapy/foreignScrape/items.py</span>. Any new items must be instantiated here. To define a new item or adjust an existing one, simply redefine it in the crawler script using the variable <span class="code">item['itemName']</span>. Here, BeautifulSoup is used to parse body text, while simple HTML response parsers are used for other items.
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 0.5em; );
 ">
                <header class="jumbotron special" style="font-size:18px;text-align:left;width:85%">
                    <div>def parse(self, response):<div>
                        <div style="text-indent:40px;">analyzeThis = response.xpath("//body").extract_first()</div>
                        <div style="text-indent:40px;">item = foreignScrapeItem() #instantiates predefined items (items.py)</div>
                        <div style="text-indent:40px;">soup = BeautifulSoup(analyzeThis, 'lxml')</div>
                        <div style="text-indent:40px;">item['name'] = response.xpath("//title").extract()[6:][:-8] #strips excess title text</div>
                        <div style="text-indent:40px;">item['id'] = response.url</div>
                        <div style="text-indent:40px;">item['bodyText'] = soup.body.get_text()[:-568] #strips off excess text</div>
                 </header>
            </div>
        </div>



        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 0.5em;">
                Currently, both crawlers are calibrated to exclude extraneous webpage data. To adjust crawler scraping scope, PoliScrape utilizes a filter with a simple <span class="code">for</span> loop and <span class="code">if</span> statement inside the <span class="code">parse()</span> class method. URLs that do not contain a keyword such as <span class="code">"frus1945"</span> are excluded from the crawler's queue. This keyword can be replaced, or additional keywords added.
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 0.5em;">
                <header class="jumbotron special" style="font-size:18px;text-align:left;width:85%">
                    <div>def parse(self, response):<div>
                    <div style="text-indent:40px;">...</div>
                    <div style="text-indent:40px;">roughLinks = response.xpath('//a/@href').extract()</div>
                    <div style="text-indent:40px;">fineLinks = []</div>
                    <div style="text-indent:40px;">for url in roughLinks:</div>
                        <div style="text-indent:80px;">if "frus1945" in url:</div>
                            <div style="text-indent:120px;">fineLinks.append(url)</div>
                    <div style="text-indent:40px;">item['urls'] = ["https://history.state.gov/"+link for link in fineLinks]</div>
                    <div style="text-indent:40px;">for url in fineLinks:</div>
                        <div style="text-indent:80px;">try:</div>
                            <div style="text-indent:120px;">yield scrapy.Request("https://history.state.gov/"+url, callback=self.parse)</div>
                        <div style="text-indent:80px;">except: </div>
                            <div style="text-indent:120px;">print("Could not parse URL! "+url)</div>
                    <div style="text-indent:40px;">yield item #sends items to item pipeline (settings.py, pipelines.py)</div>
                </header>
            </div>
        </div>

    </div>

        
        
        <!-- Page Features -->
        <!-- /.row -->

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
        		    
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <?php include_once('PoliScrape-foot.php'); ?>

</body>

</html>
