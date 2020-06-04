CREATE TABLE [dbo].[Passwords](
	[UserID] [int] IDENTITY(1,1) NOT NULL,
	[UserLogin] [char](128) UNIQUE NOT NULL,
	[HashedPassword] [char](128) NOT NULL,
	[Nonce] [char](12) NOT NULL,
	[Version] [int] NOT NULL,
	[Compromised] [bit] NOT NULL,
	[Rotation] [int] NOT NULL,
 CONSTRAINT [PK_Passwords] PRIMARY KEY CLUSTERED 
(
	[UserID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO


