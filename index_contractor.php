index_contractor
<!DOCTYPE html>
<html>
  <head>
    <title>网站标题</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <!-- 头部 -->
    <?php include 'header.php'; ?>  
    
    <!-- Banner 区域 -->
   <section id="banner">
  <div class="banner-container">
    <div class="links">
      <h1>合作伙伴申请</h1>
      <h1>服务列表</h1>
      <h1>会员权益</h1>
    </div>
  </div>
</section>

    <!-- 主体部分 -->
    <main>
      <!-- 网站服务目的和介绍 -->
      <section id="purpose">
        <div class="container">
          <h2>网站服务目的和介绍</h2>
          <p>这里是网站服务的介绍，大概200字左右的内容。这里需要写清楚我们提供的服务是什么，以及我们的服务特点。</p>
        </div>
      </section>

      <!-- 服务内容 -->
      <section id="services">
        <div class="container">
          <h2>服务内容</h2>
          <ul>
            <li><a href="#">房屋装修</a></li>
            <li><a href="#">房屋维护</a></li>
            <li><a href="#">房屋设计</a></li>
            <li><a href="#">园艺设计</a></li>
            <li><a href="#">清洁服务</a></li>
            <li><a href="#">运输搬家</a></li>
            <li><a href="#">其他</a></li>
          </ul>
        </div>
      </section>

      <!-- 操作步骤 -->
      <section id="steps">
        <div class="container">
          <h2>操作步骤</h2>
          <div class="steps-container">
            <div class="step">
              <img src="step1.png" alt="步骤 1">
			</div>
            <div class="step">
              <img src="step2.png" alt="步骤 2">
            </div>
            <div class="step">
              <img src="step3.png" alt="步骤 3">
            </div>
          </div>
		</div>
       </section>
		  
	<section class="membership" style="background-color: #CCE2EB;">
  <div class="container">
    <h2 style="text-align: center; font-family: '华文行楷', sans-serif; font-size: 2rem;">会员权益</h2>
    <p>作为我们的会员，您可以享受以下权益：</p>
    <ul style="text-align: center;">
      <li>优先预约服务</li>
      <li>免费上门勘察</li>
      <li>专属服务顾问</li>
      <li>免费赠送清洁服务</li>
      <li>特别折扣活动</li>
    </ul>
  </div>
</section>
    
    <section class="team" style="background-color: #aee4c4">
  <h2 style="text-align: center; font-family: 'Microsoft Yahei', sans-serif;">服务团队</h2>
  <div class="team-carousel" style="display: flex; justify-content: space-between; padding: 30px;">
    <div class="team-member" style="width: 18%; background-color: white; border-radius: 10px; text-align: center; padding: 20px;">
      <img src="team1.jpg" alt="团队成员 1">
      <h3 style="font-family: 'LiSu', cursive;">张三</h3>
      <p>装修设计师</p>
    </div>
    <div class="team-member" style="width: 18%; background-color: #e2f0d9; border-radius: 10px; text-align: center; padding: 20px;">
      <img src="team2.jpg" alt="团队成员 2">
      <h3 style="font-family: 'LiSu', cursive;">李四</h3>
      <p>清洁服务员</p>
    </div>
    <div class="team-member" style="width: 18%; background-color: white; border-radius: 10px; text-align: center; padding: 20px;">
      <img src="team3.jpg" alt="团队成员 3">
      <h3 style="font-family: 'LiSu', cursive;">王五</h3>
      <p>运输工人</p>
    </div>
    <div class="team-member" style="width: 18%; background-color: #e2f0d9; border-radius: 10px; text-align: center; padding: 20px;">
      <img src="team4.jpg" alt="团队成员 4">
      <h3 style="font-family: 'LiSu', cursive;">赵六</h3>
      <p>园艺设计师</p>
    </div>
    <div class="team-member" style="width: 18%; background-color: white; border-radius: 10px; text-align: center; padding: 20px;">
      <img src="team1.jpg" alt="团队成员 1">
      <h3 style="font-family: 'LiSu', cursive;">张三</h3>
      <p>装修设计师</p>
    </div>
  </div>
  <div style="background-color: #e2f0d9; height: 20px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;"></div>
</section>
    
    <section class="reviews">
  <h2>客户评价</h2>
  <div class="review-carousel">
    <div class="review-section">
      <div class="review">
        <p>他们做的很好，我很满意他们的服务。</p>
        <h3>—— 李先生</h3>
      </div>
    </div>
    <div class="review-section">
      <div class="review">
        <p>服务很到位，态度很好，值得信赖。</p>
        <h3>—— 张女士</h3>
      </div>
    </div>
    <div class="review-section">
      <div class="review">
        <p>很专业，服务态度也很好，值得推荐。</p>
        <h3>—— 王先生</h3>
      </div>
    </div>
  </div>
</section>
  </main>

  <footer class="footer">
  <div class="info">
    <h3>公司介绍</h3>
    <p>我们是一家提供房屋装修、维护、设计、园艺设计、清洁服务、运输搬家等多种服务的公司。</p>
    <p>联系方式：</p>
    <p>电话：010-12345678</p>
    <p>邮箱：info@company.com</p>
  </div>
  <div class="partner">
    <h3>合作伙伴</h3>
    <div class="partners">
      <li><img src="partner1.png" alt="合作伙伴 1"></li>
      <li><img src="partner2.png" alt="合作伙伴 2"></li>
      <li><img src="partner3.png" alt="合作伙伴 3"></li>
      <li><img src="partner4.png" alt="合作伙伴 4"></li>
    </div>
  </div>
</footer>
		
  <!-- 版权信息 -->
  <div class="copy-right">
    <p>版权所有 &copy; 2023 - 公司名称</p>
  </div>
</body>
</html>